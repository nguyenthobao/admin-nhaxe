<?php
include(DIR_CLASS.'diff_match_patch.php');
class Filemanager2
{
  protected $base = null;

  protected function real($path) {
    $temp = realpath($path);
    if(!$temp) { throw new Exception('Path does not exist: ' . $path); }
    if($this->base && strlen($this->base)) {
      if(strpos($temp, $this->base) !== 0) { throw new Exception('Path is not inside base ('.$this->base.'): ' . $temp); }
    }
    return $temp;
  }
  protected function path($id) {
    $id = str_replace('/', DIRECTORY_SEPARATOR, $id);
    $id = trim($id, DIRECTORY_SEPARATOR);
    $id = $this->real($this->base . DIRECTORY_SEPARATOR . $id);
    return $id;
  }
  protected function id($path) {
    $path = $this->real($path);
    $path = substr($path, strlen($this->base));
    $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
    $path = trim($path, '/');
    return strlen($path) ? $path : '/';
  }

  public function __construct($base) {
    $this->base = $this->real($base);
    if(!$this->base) { throw new Exception('Base directory does not exist'); }
  }
  public function lst($id, $with_root = false,$accept = null) {
    $dir = $this->path($id);
    $lst = @scandir($dir);
    if(!$lst) { throw new Exception('Could not list path: ' . $dir); }
    $res = array();
    foreach($lst as $item) {
    	
      if($item == '.' || $item == '..' || $item === null) { continue; }
      $tmp = preg_match('([^ a-zа-я-_0-9.]+)ui', $item);
      if($tmp === false || $tmp === 1) { continue; }
      if(is_dir($dir . DIRECTORY_SEPARATOR . $item)) {
        $res[] = array('text' => $item, 'children' => true,  'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'icon' => 'folder');
      }
      else {
        $ext = strpos($item, '.') !== FALSE ? substr($item, strrpos($item, '.') + 1) : '';
        if ($accept!=null) {
          if (!in_array($ext,$accept)) {
            continue;
          }
        }
        $res[] = array('text' => $item, 'children' => false, 'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'type' => 'file', 'icon' => 'file file-'.substr($item, strrpos($item,'.') + 1));
      }
    }
    if($with_root && $this->id($dir) === '/') {
      $res = array(array('text' => basename($this->base), 'children' => $res, 'id' => '/', 'icon'=>'folder', 'state' => array('opened' => true, 'disabled' => true)));
    }
    return $res;
  }
  public function data($id) {
    if(strpos($id, ":")) {
      $id = array_map(array($this, 'id'), explode(':', $id));
      return array('type'=>'multiple', 'content'=> 'Multiple selected: ' . implode(' ', $id));
    }
    $dir = $this->path($id);
    if(is_dir($dir)) {
      return array('type'=>'folder', 'content'=> $id);
    }
    if(is_file($dir)) {
      $ext = strpos($dir, '.') !== FALSE ? substr($dir, strrpos($dir, '.') + 1) : '';
      $dat = array('type' => $ext, 'content' => '');
      switch($ext) {
        case 'txt':
        case 'text':
        case 'md':
        case 'js':
        case 'json':
        case 'css':
        case 'html':
        case 'htm':
          $dat['content'] = file_get_contents($dir);
          //$file = fopen($dir,'r') or die("Unable to open file!");
          //$dat['content'] = fread($file,filesize($dir));
          break;
        case 'xml':
        case 'c':
        case 'cpp':
        case 'h':
        case 'sql':
        case 'log':
        case 'py':
        case 'rb':
        case 'htaccess':
        case 'php':
          $file = fopen($dir,'r') or die("Unable to open file!");

          $dat['content'] = fread($file,filesize($dir));

          //$dat['content'] = file_get_contents($dir);
          break;
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':
        case 'bmp':
          $dat['content'] = 'data:'.finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dir).';base64,'.base64_encode(file_get_contents($dir));
          break;
        default:
          $dat['content'] = 'File not recognized: '.$this->id($dir);
          break;
      }
      return $dat;
    }
    throw new Exception('Not a valid selection: ' . $dir);
  }
  public function create($id, $name, $mkdir = false) {
    $dir = $this->path($id);
    if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
      throw new Exception('Invalid name: ' . $name);
    }
    if($mkdir) {
      mkdir($dir . DIRECTORY_SEPARATOR . $name);
    }
    else {
      file_put_contents($dir . DIRECTORY_SEPARATOR . $name, '');
    }
    return array('id' => $this->id($dir . DIRECTORY_SEPARATOR . $name));
  }
  public function rename($id, $name) {
    $dir = $this->path($id);
    if($dir === $this->base) {
      throw new Exception('Cannot rename root');
    }
    if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
      throw new Exception('Invalid name: ' . $name);
    }
    $new = explode(DIRECTORY_SEPARATOR, $dir);
    array_pop($new);
    array_push($new, $name);
    $new = implode(DIRECTORY_SEPARATOR, $new);
    if($dir !== $new) {
      if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }
      rename($dir, $new);
    }
    return array('id' => $this->id($new));
  }
  public function remove($id) {
    $dir = $this->path($id);
    if($dir === $this->base) {
      throw new Exception('Cannot remove root');
    }
    if(is_dir($dir)) {
      foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
        $this->remove($this->id($dir . DIRECTORY_SEPARATOR . $f));
      }
      rmdir($dir);
    }
    if(is_file($dir)) {
      unlink($dir);
    }
    return array('status' => 'OK');
  }
  public function move($id, $par) {
    $dir = $this->path($id);
    $par = $this->path($par);
    $new = explode(DIRECTORY_SEPARATOR, $dir);
    $new = array_pop($new);
    $new = $par . DIRECTORY_SEPARATOR . $new;
    rename($dir, $new);
    return array('id' => $this->id($new));
  }
  public function copy($id, $par) {
    $dir = $this->path($id);
    $par = $this->path($par);
    $new = explode(DIRECTORY_SEPARATOR, $dir);
    $new = array_pop($new);
    $new = $par . DIRECTORY_SEPARATOR . $new;
    if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }

    if(is_dir($dir)) {
      mkdir($new);
      foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
        $this->copy($this->id($dir . DIRECTORY_SEPARATOR . $f), $this->id($new));
      }
    }
    if(is_file($dir)) {
      copy($dir, $new);
    }
    return array('id' => $this->id($new));
  }
  public function save($id,$fileContents){

    if($file = fopen($this->path($id), 'w+')){
        $write = fwrite($file,$fileContents);
        if ($write === false){
            $this->status = "error";
            $this->message = "could not write to file";
            //return $this->status.'|'.$this->message;
            echo json_encode($this->status.'|'.$this->message);exit();
        } else {
            clearstatcache();
            $this->data = '"mtime":'.filemtime($this->path($id));
            return true;
        }

        fclose($file);
    }
  }
}

?>