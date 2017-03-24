<?php
header('content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin:*');
error_reporting(E_ALL);
ini_set('display_errors', 1); //
/**
 * @note 七牛云存储服务
 * @author murry
 *
 */
require_once(dirname(__FILE__) . '/qiniu/autoload.php');
use Qiniu\Auth;

class uploadQN{
	private static $uid='self';
	private static $ak = 'xxx';
	private static $sk = 'xxx';
	private static $bucket = 'pekingpiao';
	private static $domain = 'htttp:://on7dmoyhq.bkt.clouddn.com';
	

    public function getQiniuToken(){

        $uid = self::$uid;
        $policy = array(
            'callbackUrl' => 'http://pekingpiao.com/xxxx.php',
            'callbackBody' => '{"fname":"$(fname)", "fkey":"$(key)", "desc":"$(x:desc)", "uid":' . $uid . '}'
        );

        $qiniu = new Auth(self::$ak, self::$sk);
        $token = $qiniu->uploadToken(self::$bucket, null, 3600, $policy);
        return $token;
    }
}

$up = new uploadQN();

?>
<form enctype="multipart/form-data" id="upload">
    <input name="token" type="hidden" value="<?php echo $up->getQiniuToken();?>">
    <input name="file" type="file" />
	<a href="javascript:void(0);" id="up">上传</a>
</form>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript">
	$(function(){
		$('#up').on('click',function(){
			var options ={
				async:false,
				url:'//up-z1.qiniu.com',
				type:'post',
				data:null,
				dataType:'json',
				success:function(res){
					console.log(res);
					if(res.success){
						alert('上传成功');
					}else{						
						alert('上传失败');
					}
				}
			};
			$('#upload').ajaxSubmit(options);
		});
	})

</script>

