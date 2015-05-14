<?php namespace Seansch\Interspire;


class InterspireWrapper {

    private function postData($xml)
    {
        $ch = curl_init(config('interspire.url'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);

        if($result === false) {
            return false;
        } else {
            $xml_doc = simplexml_load_string($result);

            if ($xml_doc->status == 'SUCCESS') {
                return true;
            } else {
                return false;
            }
        }

    }

    public function addSubscriberToList($name, $surname, $email, $list_id)
    {
        $xml = '<xmlrequest>
		<username>'.config('interspire.user').'</username>
		<usertoken>'.config('interspire.token').'</usertoken>
		<requesttype>subscribers</requesttype>
		<requestmethod>AddSubscriberToList</requestmethod>
		<details>
		<emailaddress>'.$email.'</emailaddress>
		<mailinglist>'.$list_id.'</mailinglist>
		<format>html</format>
		<confirmed>yes</confirmed>
		<customfields>
		<item>
		<fieldid>2</fieldid>
		<value>'.$name.'</value>
		</item>
		<item>
		<fieldid>3</fieldid>
		<value>'.$surname.'</value>
		</item>
		</customfields>
		</details>
		</xmlrequest>';

        $this->postData($xml);
    }

    public function deleteSubscriber($email)
    {
        $xml = '<xmlrequest>
		<username>'.config('interspire.user').'</username>
		<usertoken>'.config('interspire.token').'</usertoken>
		<requesttype>subscribers</requesttype>
		<requestmethod>DeleteSubscriber</requestmethod>
		<details>
		<emailaddress>'.$email.'</emailaddress>
		<list>1</list>
		</details>
		</xmlrequest>';

        $this->postData($xml);
    }

    /**
     * @param string $email
     * @param int $list_id
     */
    public function isOnList($email, $list_id)
    {
        $xml = '<xmlrequest>
		<username>'.config('interspire.user').'</username>
		<usertoken>'.config('interspire.token').'</usertoken>
		<requesttype>subscribers</requesttype>
		<requestmethod>IsSubscriberOnList</requestmethod>
		<details>
		<Email>'.$email.'</Email>
		<List>'.$list_id.'</List>
		</details>
		</xmlrequest>';

        dd($xml);
        $this->postData($xml);
    }

}