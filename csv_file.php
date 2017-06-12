<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/2/17 AD
 * Time: 12:53
 */

class csv_file {

    public static function makecsv($data, $csvfilename,$scriptrun = null)
    {
        if (null === $scriptrun){
            $scriptrun = true;
        }
        $list = $data;

        $file = fopen($csvfilename,"w");
        fputcsv($file,array($GLOBALS['schoolName'],
                $GLOBALS['suburb']."/".$GLOBALS['city']."/Australia")
        );

        foreach ($list as $line)
        {
            fputcsv($file,$line);
        }

        fclose($file);
        if ($scriptrun) {

            //TODO: check in file to best return

            echo "<script type='text/javascript'>
				location.replace($csvfilename);
				</script>";
        }

    }

}