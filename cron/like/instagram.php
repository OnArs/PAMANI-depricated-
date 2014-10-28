<?php

class Instagram {

	private $request;
	private $account;

	public function __construct()
	{
		$this->request = new RollingCurl();
	}

	public function opt()
	{
        $proxy = array(
                        '172.241.216.132',
                        '172.241.216.229',
                        '172.241.216.40',
                        '172.241.216.70',
                        '23.106.211.163',
                        '23.106.211.199',
                        '23.106.211.61',
                        '23.106.211.72',
                        '23.106.26.103',
                        '23.106.26.152',
                        '23.106.26.191'
                    );

        $port = '29842';
        $login_pass = "aibragim:VLgpcmMq";

        $proxy = $proxy[rand(0, count($proxy)-1)];

		return array(
			CURLOPT_COOKIEFILE 	=> APP .'local/cookies/'. $this->account[0],
			CURLOPT_COOKIEJAR	=> APP .'local/cookies/'.  $this->account[0],
            CURLOPT_USERAGENT	=> 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36',
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HEADER => 1,
			CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_PROXYTYPE => 'HTTP',
            CURLOPT_PROXY => $proxy.":".$port,
            CURLOPT_PROXYUSERPWD => $login_pass
		);
	}

	public function login($account)
	{
		list($id, $login, $pass) = $this->account;

		$opt = $this->opt();

		$this->request->get('https://instagram.com/accounts/login/', null, $opt);
		$result = $this->request->execute();

        preg_match('|"csrf_token"\:"(.*)"|U', $result, $out);

        $data = "username={$login}&password={$pass}&intent=&csrfmiddlewaretoken=". trim($out[1]);

		$opt[CURLOPT_REFERER] = 'https://instagram.com/accounts/login/';
        $opt[CURLOPT_HTTPHEADER] = array(
            'X-Requested-With:XMLHttpRequest',
            'X-CSRFToken:'. $out[1]
        );


        $this->request->post('https://instagram.com/accounts/login/ajax/', $data, 1, $opt);
        $result = $this->request->execute();

        //@file_put_contents('/var/www/pamani/pamani.ru/test/local/html/'.$login.'.html',
        //    '['. date("d-m-y H:i:s") .'] login:' . $login.' '.strpos($result, $login).' '.$result . PHP_EOL);

	    if (strpos($result, "Please enter a correct")==0) {
	    	return true;
	    }

	    return false;
	}

	public function isAuth()
	{
		$this->request->get('https://instagram.com/', null, $this->opt());

		return strpos($this->request->execute(), $this->account[1]) !== false;
	}

	public function lister($account, $url, $data)
	{
        /*$link = new mysqli(
            'localhost',
            'pamani_clike4',
            'clike4',
            'pamani_pam'
        );*/

        //$debag_id = 110;

		$this->account = $account;

		if (file_exists('/var/www/pamani/pamani.ru/cron/like/local/cookies/'. $this->account[0])) {
			// Проверка действительности кук
			if ($this->isAuth()) {
				
				// Аккаунт авторизован, проделываем что нужно
				$this->request->get('http://instagram.com/p/o-_qFzIOU3/', null, $this->opt());
				$result = $this->request->execute();
				//echo $result;
				preg_match('|"csrf_token":"(.*)"|U', $result, $out);

				$opt = $this->opt();
				//$opt[CURLOPT_REFERER] = 'http://instagram.com/p/o-_qFzIOU3/';
				$opt[CURLOPT_HTTPHEADER] = array(
					'X-Instagram-AJAX:1',
					'X-Requested-With:XMLHttpRequest',
					'X-CSRFToken:'. $out[1]
					);
				$this->request->post($url, $data, null, $opt);

                //if ($account[0]==$debag_id) {$debag=' <---';} else {unset($debag);}
                //$this->log('Отправлен запрос на like от ID: '. $account[0].$debag);

				return $this->request->execute();

			} else {

                unlink('/var/www/pamani/pamani.ru/cron/like/local/cookies/'.$account[0]);
				// Если аккаунт не авторизован, пробуем авторизоваться
				/*
                if ($this->login($account)) {
					// После удачной авторизации запускаем функцию снова с тем же аккаунтом
					$this->lister($account, $url, $data);
				} else {

                    if ($account[0]==$debag_id) {$debag=' <---';} else {unset($debag);}
					$this->log('Ошибка авторизации аккаунта ID (лог): '. $account[0].$debag);

                    $link->query("UPDATE users SET block='1' WHERE id_user='{}' LIMIT 1", MYSQLI_ASYNC);
                    $link->reap_async_query();
				}
				*/
			}
		} else {
            //if ($account[0]==$debag_id) {$debag=' <---';} else {unset($debag);}
            //$this->log('Отсутствует файл cookie от ID: '. $account[0].$debag);

			// Если аккаунт не авторизован, пробуем авторизоваться
			if ($this->login($account)) {
				// После удачной авторизации запускаем функцию снова с тем же аккаунтом
				$this->lister($account, $url, $data);

                //if ($account[0]==$debag_id) {$debag=' <---';} else {unset($debag);}
                //$this->log('error_code13: '. $account[0].$debag);

			} else {
                //if ($account[0]==$debag_id) {$debag=' <---';} else {unset($debag);}
				//$this->log('Ошибка авторизации аккаунта ID (кук и лог): '. $account[0].$debag);

                /*$link->query("UPDATE users SET block='1' WHERE id_user='{$account[0]}' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();*/
                return "block2"; // на стороне воркера после этого сообщения нужно блокировать
			}
		}
	}

	public function log($error)
	{
		//@file_put_contents('/var/www/pamani/pamani.ru/cron/like/local/error_log.txt', '['. date("d-m-y H:i:s") .'] '. $error . PHP_EOL, FILE_APPEND);
	}
}