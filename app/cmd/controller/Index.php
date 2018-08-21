<?php

	namespace app\cmd\controller;
	//压缩图片功能
	//文件转义重命名
	//删除空文件夹
	//文件去重

	//spl接口


	//php index.php /cmd/index/index


	use image\imageProcessor;
	use PhpMyAdmin\SqlParser\Parser;
	use PhpMyAdmin\SqlParser\Utils\Query;
	use PHPSQLParser\PHPSQLParser;

	class Index
	{

		//public $testImg = 'C:\Users\Administrator\Desktop\pic\a.jpg';
		public $testImg = 'C:\Users\Administrator\Desktop\pic\b.png';
		public $testPath = 'C:\Users\Administrator\Desktop\test\\';
		public static $hashMap = [];

		public function rename()
		{
			$path = 'C:\Users\Administrator\Desktop\emo';

			loop2($path , function($path , $dirs_ , $relativePath) {
				//echo '------' . $relativePath . "\r\n";
				//echo '------' . $path . "\r\n";
				//echo "\r\n";

				//返回真继续遍历下层，否则停止遍历此文件夹
				return 1;

			} , function($path , $pathinfo , $relativePath) {
				$pathinfo = pathinfo_($path);

				$reader = \PHPExif\Reader\Reader::factory(\PHPExif\Reader\Reader::TYPE_NATIVE);
				$exif = $reader->read($path);

				if($exif)
				{
					$data = $exif->getRawData();
					//$data = \exif_read_data($path);

					$name = date('Y-m-d-H-i-s' , $data['FileDateTime']) . '-' . $data['FileSize'] . '-' . $pathinfo['basename'];
					$dest = 'C:\Users\Administrator\Desktop\pic' . dirname($relativePath) . '/' . $name;
				}
				else
				{
				}
					$dest = 'C:\Users\Administrator\Desktop\pic' . dirname($relativePath)  . md5(uniqid($pathinfo['basename'], 1)).'.'.$pathinfo['extension'];

				$a = md5_file($path);
				echo '++++++' . $relativePath . '  --  ' . $a . "\r\n";
				echo '++++++' . $path . "\r\n";
				echo '------' . $dest . "\r\n";
				echo "\r\n";

				if(!in_array($a , self::$hashMap))
				{
					self::$hashMap[] = $a;

					mkdir_(dirname($dest));

					if(in_array(strtolower($pathinfo['extension']) , [
						'jpeg' ,
						'jpg' ,
					]))
					{

						$imageCompress = imageProcessor::getProcessor('compress');
						$ratio = 8;
						$imageCompress->form($path)->ratio($ratio)->to($dest);
					}
					else
					{
						copy($path , $dest);
					}

				}
			});
		}

		/**
		 * @throws \ReflectionException
		 */
		public function compress()
		{
			//https://blog.csdn.net/qq_36608163/article/details/73167284
			$imageCompress = imageProcessor::getProcessor('compress');

			$info = pathinfo($this->testImg);
			$ratio = 10;
			$imageCompress->form($this->testImg)->ratio($ratio)->to($this->testPath . '/' . $ratio . '_' . $info['basename']);
		}

		public function thumb()
		{
			$info = pathinfo($this->testImg);
			$image = imageProcessor::Image()::open($this->testImg);

			mkdir_($this->testPath);
			$image->thumb(300 , 300)->save($this->testPath . '/thumb.png' , 'png');
		}


		public function removeEmpty()
		{
			$path = 'c:';

			rm_empty_dir($path);
		}

		public function sqlParser()
		{
			$query1 = "
SELECT 
    table1.customer_id,
    city,
    COUNT(order_id) 
FROM
    table1 
    left JOIN table2 
        ON table1.customer_id = table2.customer_id 
WHERE table1.customer_id <> 'tx' 
    AND table1.customer_id <> '9you' 
GROUP BY customer_id 
HAVING COUNT(order_id) > ANY 
    (SELECT 
        COUNT(order_id) 
    FROM
        table2 
    WHERE customer_id = 'tx' 
        OR customer_id = '9you' 
    GROUP BY customer_id) ;
";
			$parser = new Parser($query1);

			$flags = Query::getFlags($parser->statements[0]);
			print_r($parser);;;
			//print_r($flags);;;
		}


		public function sqlParser1()
		{
			$query1 = "
SELECT 
    table1.customer_id,
    city,
    COUNT(order_id) 
FROM
    table1 
    left JOIN table2 
        ON table1.customer_id = table2.customer_id 
WHERE table1.customer_id <> 'tx' 
    AND table1.customer_id <> '9you' 
GROUP BY customer_id 
HAVING COUNT(order_id) > ANY 
    (SELECT 
        COUNT(order_id) 
    FROM
        table2 
    WHERE customer_id = 'tx' 
        OR customer_id = '9you' 
    GROUP BY customer_id) ;
";
			/*
			$query1 = "
INSERT INTO `ithink_area` (`id`, `code`, `name`, `pid`, `level`) 
VALUES
    (9, 31, '上海市', 0, 1) ;
";

		*/
			$parser = new PHPSQLParser();
			$parsed = $parser->parse($query1, true);
			print_r($parsed);
		}

	}














