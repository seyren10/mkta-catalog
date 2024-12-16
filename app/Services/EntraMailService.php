<?php
namespace App\Services;

use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Models\Attachment;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\FileAttachment;
use Microsoft\Graph\Generated\Users\Item\SendMail\SendMailPostRequestBody;

use GuzzleHttp\Psr7\Utils;

use Illuminate\Support\Facades\Storage;

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

    public function sendMail($subject, $mail_message, $recipient, $is_html = false){
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

    /**
     * Send mail with attachment (Excel file).
     *
     * @param string $subject
     * @param string $mail_message
     * @param string $recipient
     * @param mixed $data
     * @param string $filename
     * @param bool $is_html
     * @return mixed
     */
    public function sendMailWithAttachment($subject, $mail_message, $recipient, $filePath, $filename, $is_html = false)
    {
        // Create the Graph client with token authentication
        $tokenRequestContext = new ClientCredentialContext(
            $this->tenant_id,
            $this->client_id,
            $this->client_secret
        );

        $graphServiceClient = new GraphServiceClient($tokenRequestContext);

        // Prepare the message
        $message = new Message();
        $message->setSubject($subject);

        // Set the body of the message
        $messageBody = new ItemBody();
        $messageBody->setContentType(new BodyType($is_html ? 'HTML' : 'Text'));
        $messageBody->setContent($mail_message);
        $message->setBody($messageBody);

        // Set the recipient
        $toRecipientsRecipient = new Recipient();
        $toRecipientsRecipientEmailAddress = new EmailAddress();
        $toRecipientsRecipientEmailAddress->setAddress($recipient);
        $toRecipientsRecipient->setEmailAddress($toRecipientsRecipientEmailAddress);
        $toRecipientsArray[] = $toRecipientsRecipient;

        $message->setToRecipients($toRecipientsArray);

        $fileStream = fopen($filePath, 'r');
        if ($fileStream === false) {
            throw new \RuntimeException("Failed to open file: $filePath");
        }
        
        // Read the binary content of the file
        $fileContents = stream_get_contents($fileStream);
        if ($fileContents === false) {
            throw new \RuntimeException("Failed to read the file contents.");
        }
        
        // Optionally encode the binary data as base64 (required for OData Edm.Binary)
        $binaryData = base64_encode($fileContents);
        
        // Convert to PSR-7 stream
        $psr7Stream = \GuzzleHttp\Psr7\Utils::streamFor($binaryData);
        if (!$psr7Stream) {
            throw new \RuntimeException("Failed to convert binary data to PSR-7 stream.");
        }
        
        // Close the original file stream
        fclose($fileStream);

        \Log::info('PSR-7 Stream type: ' . get_class($psr7Stream)); // Corrected logging for stream type
        \Log::info('Stream size: ' . $psr7Stream->getSize()); // Corrected logging for stream size

        // Create file attachment from the stream
        $attachmentsAttachment = new FileAttachment();
        $attachmentsAttachment->setOdataType('#microsoft.graph.fileAttachment');
        $attachmentsAttachment->setName($filename);
        $attachmentsAttachment->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $attachmentsAttachment->setContentBytes($psr7Stream);

        $attachmentsArray[] = $attachmentsAttachment;
        $message->setAttachments($attachmentsArray);

        // Prepare the request body
        $requestBody = new SendMailPostRequestBody();
        $requestBody->setMessage($message);

        // Send the email with the attachment
        return $graphServiceClient->users()
                                ->byUserId($this->email_id)
                                ->sendMail()
                                ->post($requestBody)
                                ->wait();
    }
}
