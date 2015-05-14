<?php namespace Seansch\Interspire;

use GuzzleHttp;

class Interspire {

    private $client;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client([
            'base_url' => [config('interspire.url'), []],
            'defaults' => [
                'headers' => ['content-type' => 'text/xml']
            ]
        ]);
    }

    /**
     * Sends the request to the Interspire Server
     *
     * @param $xml
     * @return bool
     */
    private function postData($xml)
    {
        $response = $this->client->post('', ['body' => $xml])->xml();
        if ($response->status == "SUCCESS") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adds a subscriber to the specified list.
     * Takes an array of fields which are checked against
     * Interspire and then sets up their xml
     *
     * @param string $email
     * @param int $list_id
     * @param array $fields
     * @return bool|string
     */
    public function addSubscriberToList($email, $list_id, array $fields)
    {
        $custom_fields = $this->getCustomFields($list_id);

        $custom_field_xml = '';
        foreach ($fields as $key => $val) {
            // Check that the field exists in the contact list and setup its xml
            if (array_key_exists($key, $custom_fields)) {
                $custom_field_xml .= '
                    <item>
                        <fieldid>'.$custom_fields[$key].'</fieldid>
                        <value>'.$val.'</value>
                    </item>
                ';
            } else {
                return $key.": Not a valid field";
            }
        }

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
        '.$custom_field_xml.'
		</customfields>
		</details>
		</xmlrequest>';

        return($this->postData($xml));
    }

    /**
     * Deletes a subscriber from the specified list
     *
     * @param string $email
     * @param int $list_id
     * @return bool
     */
    public function deleteSubscriber($email, $list_id)
    {
        $xml = '<xmlrequest>
		<username>'.config('interspire.user').'</username>
		<usertoken>'.config('interspire.token').'</usertoken>
		<requesttype>subscribers</requesttype>
		<requestmethod>DeleteSubscriber</requestmethod>
		<details>
		<emailaddress>'.$email.'</emailaddress>
		<list>'.$list_id.'</list>
		</details>
		</xmlrequest>';

        return($this->postData($xml));
    }

    /**
     * Checks if an email is on a specified list
     *
     * @param $email
     * @param $list_id
     * @return bool
     */
    public function isOnList($email, $list_id)
    {
        $xml = '<xmlrequest>
            <username>'.config('interspire.user').'</username>
            <usertoken>'.config('interspire.token').'</usertoken>
            <requesttype>subscribers</requesttype>
            <requestmethod>IsSubscriberOnList</requestmethod>
            <details>
            <emailaddress>'.$email.'</emailaddress>
            <listids>'.$list_id.'</listids>
            </details>
            </xmlrequest>';

        return($this->postData($xml));
    }

    /**
     * Retrieve all of the custom fields associated with a list
     *
     * @param $list_id
     * @return array
     */
    public function getCustomFields($list_id)
    {
        $xml = '<xmlrequest>
            <username>'.config('interspire.user').'</username>
            <usertoken>'.config('interspire.token').'</usertoken>
            <requesttype>lists</requesttype>
            <requestmethod>GetCustomFields</requestmethod>
            <details>
            <listids>'.$list_id.'</listids>
            </details>
            </xmlrequest>';

        $response = $this->client->post('', ['body' => $xml])->xml();

        $custom_fields = [];
        foreach ($response->data->item as $line) {
            $custom_fields[str_slug((string)$line->name, "_")] = (string)$line->fieldid;
        }

        return $custom_fields;
    }
}