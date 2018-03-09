<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Picture.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-03 16:46:49
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use think\Model;

class Picture extends Model
{
    /**
     * [ saveCover 内容管理对封面图片的处理 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-30T09:46:32+0800
     * @param    string                   $coverData  [封面图像数据，type为1时是base64数据，type为2时是文件路径]
     * @param    int                      $type       [状态，1为开始（默认），2为成功之后，3为不成功时删除数据]
     * @return   string                               []
     */
    public function saveCover($coverData = null, $type = 1)
    {
        $pathTemp   = '../data/temp/'; // 临时文件夹路径
        $pathImages = './data/images/'; // 图像文件文件夹路径

        if ($type == 1) {
            //匹配出图片的格式
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $coverData, $result)) {
                $type     = $result[2]; // 图像格式
                $dateFile = date('Ymd', time()) . '/'; // 日期目录

                $allPathTemp   = $pathTemp . $dateFile; // 全部路径
                $allPathImages = $pathImages . $dateFile;

                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                file_exists($allPathTemp) || make_dir($allPathTemp);
                file_exists($allPathImages) || make_dir($allPathImages);

                $filename     = md5(time()) . '.' . $type; // md5加密后的文件名（带后缀）
                $filePathTemp = $allPathTemp . $filename; // 文件的位置
                if (file_put_contents($filePathTemp, base64_decode(str_replace($result[1], '', $coverData)))) {
                    if (file_exists($filePathTemp)) {
                        $image = \think\Image::open($filePathTemp);
                        if ($image) {
                            $filePath = $allPathImages . $filename;
                            // 按照原图的比例生成一个最大为150*150的缩略图并保存为封面图像，最后删除临时文件
                            $image->thumb(400, 400)->save($filePath) && unlink($filePathTemp);
                        }

                        $data['path']        = $dateFile . $filename;
                        $data['create_time'] = time();
                        $data['md5']         = md5_file($filePath);
                        $data['sha1']        = sha1($filePath);

                        $this->save($data);
                        return $this->id;
                    }
                } else {
                    return 0;
                }
            }
        } elseif ($type == 2) {
            $tempArr  = explode('/', $coverData); // 以/拆分数据
            $dateFile = $tempArr[0] . '/'; // 日期目录
            $filename = $tempArr[1]; // 文件名（带后缀）
            $allPath  = $pathImages . $dateFile; // 全部路径
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            file_exists($allPath) || make_dir($allPath);

            $tempFilePath = $pathTemp . $coverData; // 临时文件位置

            // 检查文件是否存在
            if (file_exists($tempFilePath)) {
                $image = \think\Image::open($tempFilePath);
                if ($image) {
                    $filePath = $allPath . $filename;
                    // 按照原图的比例生成一个最大为150*150的缩略图并保存为封面图像，最后删除临时文件
                    $image->thumb(400, 400)->save($filePath) && unlink($tempFilePath);
                }
            }
        } elseif ($type == 3) {
            $this->where('id', $coverData)->delete();
        }

    }
}
