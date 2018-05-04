<?php 
namespace App\Libs;

//include 'imageToDownload.php';
//include 'imgZip.php';
require 'qiniusdk/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use Qiniu\Processing\PersistentFop;

class ImageDuel {
    public function create($url, $fileName) {
        $bucket = 'card';
        $thumb = 'thumb';

        $accessKey = 'IETJ-FOR2Au3FqTT20n_MNXirGR6qGjPbsBmFO0t';
        $secretKey = 'XVmHYNRMHJ2R5l_2xSGRgEfXpUc9JPBuDgBz2Mzh';
        $auth = new Auth($accessKey, $secretKey);

        $key = $fileName . '.png';
        if(strpos($url,'http') !==false){
            //抓取
            $bucketManager = new BucketManager($auth);
            list($ret, $err) = $bucketManager->fetch($url, $bucket, $key);
        }else{
            //上传
            $source =  $url.$fileName; 
            $token = $auth->uploadToken($bucket);
            $uploadMgr = new UploadManager();
            list($ret, $err) = $uploadMgr->putFile($token, $key, $source);
        }

        //生成缩略图
        $destKey = $fileName . "_thumb.jpg";
        $auth = new Auth($accessKey, $secretKey);
        $fops = 'imageView2/2/w/160/format/jpg/interlace/0/q/50|saveas/'. \Qiniu\base64_urlSafeEncode($bucket . ":" .$destKey);
        $config = new \Qiniu\Config();
        $pfop = new PersistentFop($auth, $config);
        list($id, $err) = $pfop->execute($bucket, $key, $fops);
        dump($bucket, $key, $fops);
    }
}
?>