<?php
    include 'imageToDownload.php';
    //include 'imgZip.php';
    //require 'sdk/autoload.php';
    //use Qiniu\Auth;
    //use Qiniu\Storage\UploadManager;
      // 用于签名的公钥和私钥
    

    foreach($images as $a){
        echo $a;
        crabImage($a);
    }
    
    function crabImage($imgUrl, $saveDir='./ImagesDownload/', $fileName=null){  
        if(empty($imgUrl)){  
            return false;  
        }  
          
        //获取图片信息大小  
        $imgSize = getImageSize($imgUrl);  
        if(!in_array($imgSize['mime'],array('image/jpg', 'image/gif', 'image/png', 'image/jpeg'),true)){  
            return false;  
        }  
      
        //获取后缀名  
        $_mime = explode('/', $imgSize['mime']);  
        $_ext = '.'.end($_mime);  
          
        if(empty($fileName)){  //生成唯一的文件名
            $fileName = pathinfo($imgUrl, PATHINFO_BASENAME);  
        }  
      
        //开始攫取  
        ob_start();  
        readfile($imgUrl);  
        $imgInfo = ob_get_contents();  
        ob_end_clean();  
      
        if(!file_exists($saveDir)){  
            mkdir($saveDir,0777,true);  
        }  
        $fp = fopen($saveDir.$fileName, 'a');  
        $imgLen = strlen($imgInfo);    //计算图片源码大小  
        $_inx = 1024;   //每次写入1k  
        $_time = ceil($imgLen/$_inx);  
        for($i=0; $i<$_time; $i++){  
            fwrite($fp,substr($imgInfo, $i*$_inx, $_inx));  
        }  
        fclose($fp);
/*
        //创建压缩副本
        $source =  $saveDir.$fileName;  
        $dst_img = $saveDir."zip/".$fileName;  
        $percent = 0.6530612244897959;
        $image = (new imgcompress($source,$percent))->compressImg($dst_img);

        //上传七牛云
        $bucket = 'website';
        $accessKey = 'IETJ-FOR2Au3FqTT20n_MNXirGR6qGjPbsBmFO0t';
        $secretKey = 'XVmHYNRMHJ2R5l_2xSGRgEfXpUc9JPBuDgBz2Mzh';
        $auth = new Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucket);
        $uploadMgr = new UploadManager();  
        //print_r($_FILES['file']['tmp_name']);exit;
        $key = $fileName;

        list($ret, $err) = $uploadMgr->putFile($token, $key, $source);  
        echo "\n====> putFile result: \n";  
        if ($err !== null) {  
            var_dump($err);  
        } else {  
            var_dump($ret);  
        }
      */
        return array('file_name'=>$fileName,'save_path'=>$saveDir.$fileName);  
    }  
?>