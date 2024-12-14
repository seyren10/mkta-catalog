<?php
namespace App\Services;

use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\Users\Item\SendMail\SendMailPostRequestBody;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Models\EmailAddress;

use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;

class EntraMailService
{
    public function __construct(){
        $this->client_id = config('api.entra.client_id');
        $this->client_secret = config('api.entra.client_secret');
        $this->tenant_id = config('api.entra.tenant_id');
        $this->object_id = config('api.entra.object_id');
        $this->email_id = config('api.entra.email_id');
    }

    public function sendMail($subject, $mail_message, $recipient, $is_html){
        $tokenRequestContext = new ClientCredentialContext(
            $this->tenant_id,
            $this->client_id,
            $this->client_secret,
            ['https://graph.microsoft.com/.default'] // Use only .default to leverage app permissions
        );

        $graphServiceClient = new GraphServiceClient($tokenRequestContext);

        $requestBody = new SendMailPostRequestBody();
        $message = new Message();
        $message->setSubject($subject);

        $messageBody = new ItemBody();

        if($is_html){
            $messageBody->setContentType(new BodyType('HTML'));
        }else{
            $messageBody->setContentType(new BodyType('text'));
        }

        $messageBody->setContent($mail_message);
        $message->setBody($messageBody);

        $toRecipientsRecipient = new Recipient();
        $toRecipientsRecipientEmailAddress = new EmailAddress();
        $toRecipientsRecipientEmailAddress->setAddress($recipient);
        $toRecipientsRecipient->setEmailAddress($toRecipientsRecipientEmailAddress);
        $toRecipientsArray []= $toRecipientsRecipient;
        $message->setToRecipients($toRecipientsArray);

        $requestBody->setMessage($message);
        $requestBody->setSaveToSentItems(false);

        return $graphServiceClient->users()
                                ->byUserId($this->email_id)
                                ->sendMail()
                                ->post($requestBody)
                                ->wait();
    }
}
