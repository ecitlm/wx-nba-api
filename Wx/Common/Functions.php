<?php
class Common_Functions
{
    /**
     * @param $url
     * @param bool $status
     * @return mixed
     */
    public function HttpGet($url, $status = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1000);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4');
        if ($status) {
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept:application', 'X-Request:JSON', 'X-Requested-With:XMLHttpRequest'));
        }

        //如果用的协议是https则打开这个注释、不验证https
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}
