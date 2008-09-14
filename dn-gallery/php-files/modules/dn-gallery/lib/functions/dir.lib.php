<?
function recursive_remove_directory($directory, $empty=FALSE)
 {
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
     // if the path is not valid or is not a directory ...
     if(!file_exists($directory) || !is_dir($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... else if the path is readable
     }else{
  
         // we open the directory
         $handle = opendir($directory);
  
         // and scan through the items inside
         while (FALSE !== ($item = readdir($handle)))
         {
             // if the filepointer is not the current directory
             // or the parent directory
             if($item != '.' && $item != '..')
             {
                 // we build the new path to delete
                 $path = $directory.'/'.$item;
  
                 // if the new path is a directory
                 if(is_dir($path)) 
                 {
                     // we call this function with the new path
                     recursive_remove_directory($path);
  
                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink($path);
                 }
             }
         }
         // close the directory
         closedir($handle);
  
         // if the option to empty is not set to true
         if($empty == FALSE)
         {
             // try to delete the now empty directory
             if(!rmdir($directory))
             {
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
     }
 }

 function dircopy($source, $dest, $overwrite = false){

  if($handle = opendir($source)){         // if the folder exploration is sucsessful, continue
    while(false !== ($file = readdir($handle))){ // as long as storing the next file to $file is successful, continue
      if($file != '.' && $file != '..'){
        $path = $source . '/' . $file;
        if(is_file($path)){
          if(!is_file($dest . '/' . $file) || $overwrite)
            if(!@copy($path, $dest . '/' . $file)){
              echo '<font color="red">File ('.$path.') could not be copied, likely a permissions problem.</font>';exit;
            }
        } elseif(is_dir($path)){
          if(!is_dir($dest . '/' . $file))
            mkdir($dest . '/' . $file); // make subdirectory before subdirectory is copied
          dircopy($path, $dest . '/' . $file, $overwrite); //recurse!
        }
      }
    }
    closedir($handle);
  }
} // end of dircpy()
?>