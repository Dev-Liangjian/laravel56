/*
* @Author: Dev-Liangjian
* @Date:   2019-01-09 12:06:27
* @Last Modified by:   Dev-Liangjian
* @Last Modified time: 2019-01-09 14:16:09
*/
function imgPreview(fileDom) {
    //判断是否支持FileReader
    if(window.FileReader) {
        var reader = new FileReader();
    } else {
        console.log("您的浏览器不支持图片预览功能，如需该功能请升级您的浏览器");
    }
    //获取文件
    var file = fileDom.files[0];
    var imageType = /^image\//; //匹配图片的正则表达式
    //是否是图片
    if(!imageType.test(file.type)) {
        alert("请选择图片");
        return;
    }
    //读取完成
    reader.onload = function(e) {
        //获取图片dom
        var img = document.getElementById("preview_img");
        //图片路径设置为读取的图片
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function check()
{
    var input = document.getElementById("input_file");
    if( input.value == '' ){
        alert("请选择图片");
        return false;
    }else{
        return true;
    }
}