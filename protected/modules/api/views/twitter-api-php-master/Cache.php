<?php
/**
* @desc Class that implements the Cache functionality
*/
class Cache 
{
    const PATH_TO_CACHE = 'cache/';
 
    /**
    * @desc Function read retrieves value from cache
    * @param string $fileName - name of the cache file
    * @return bool/string
    * Usage: Cache::read('fileName.extension')
    */
    function read($fileName) 
    {
        $fileName = self::PATH_TO_CACHE . $fileName;
        if (file_exists($fileName)) {
            $handle = fopen($fileName, 'rb');
            $data = fread($handle, filesize($fileName));
            $data = unserialize($data);
            // checking if cache expired
            if (time() > $data[0]) {
                // it expired, delete the file
                @unlink($fileName);
                return false;
            }
            fclose($handle);
            // cache is still valid, return the data
            return $data[1];
        } else {
            return false;
        }
    }
      
    /**
    * @desc Function for writing key => value to cache
    * @param string $fileName - name of the cache file (key)
    * @param mixed $variable - value
    * @param number $ttl - time to last in milliseconds
    * @return void
    * Usage: Cache::write('fileName.extension', value)
    */
    function write($fileName, $variable, $ttl) 
    {
        $fileName = self::PATH_TO_CACHE . $fileName;
        $handle = fopen($fileName, 'a');
        fwrite($handle, serialize(array(time() + $ttl, $variable)));
        fclose($handle);
    }
      
    /**
    * @desc Function for deleting cache file
    * @param string $fileName - name of the cache file (key)
    * @return void
    * Usage: Cache::delete('fileName.extension')
    */
    function delete($fileName) 
    {
        $fileName = self::PATH_TO_CACHE . $fileName;
        @unlink($fileName);
    }
  
}
?>