/*
* @Author: Dev-Liangjian
* @Date:   2019-01-08 16:30:45
* @Last Modified by:   Dev-Liangjian
* @Last Modified time: 2019-01-09 13:02:47
*/
$("ul.navbar-left button").click(function(){
    value = $("#query").val();
    if( value.length != 0 ){
        url = '/posts/search?query='+ value;
        $.get(url);
    }
});