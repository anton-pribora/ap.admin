<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail;

use ApCode\Mail\Message\Related;
use ApCode\Mail\Message\Attachment;
use ApCode\Mail\Message\Part;
use ApCode\Mail\Message\MultiPart;
use ApCode\Mail\Message\Headers;

/**
 * Формирует EML-сообщение. Соблюдается правильная структура сообщения при вложении и подключении файлов.
 *
 * Порядок составления документа:
 * ------------------------------
 * multipart/mixed           Составной дкумент (вложения + текст)
 * |- multipart/alternative  Сообщение в нескольких форматах (простой текст + html)
 * |  |- text/plain          Простой текст
 * |  |- multipart/related   Составной документ (html + файлы)
 * |     |- text/html        HTML текст
 * |     |- Relate file A    Зависимый файл (не показывается во вложениях)
 * |     |- Relate file B    Зависимый файл (не показывается во вложениях)
 * |- Attachemnt A           Независимый файл (показывается во вложениях)
 * |- Attachment B           Независимый файл (показывается во вложениях)
 */
class Message
{
    private $charset     = 'UTF-8';

    private $subject     = null;
    private $recipients  = [];
    private $copyTo      = [];
    private $replyTo     = [];
    private $hiddenCopy  = [];
    private $content     = null;
    private $senderEmail = null;

    private $headers     = [];
    private $related     = [];
    private $attachments = [];

    public function __construct()
    {
        $this->headers = new Headers();

        $this->content = new Part();
        $this->setContentType('text/html; charset='. $this->charset);
        $this->headers
            ->set('MIME-Version', '1.0')
            ->set('Date', date(DATE_RFC1123))
        ;
    }

    /**
     * @return \ApCode\Mail\Message\Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    public function setContentType($type)
    {
        $this->content->setContentType($type);
        return $this;
    }

    public function setContentTypeTextPlain()
    {
        $this->content->setContentType('text/plainl; charset='. $this->charset);
        return $this;
    }

    public function getContentType()
    {
        return $this->content->getContentType();
    }

    public function setContent($data)
    {
        $this->content->setContent($data);
        return $this;
    }
    
    public function addContent($data)
    {
        $this->content->addContent($data);
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        $this->headers->set('Subject', $subject, true);
        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function addRecipient($mail, $name = null)
    {
        if ( $name ) {
            $this->recipients[] = "$name <$mail>";
            $this->headers->add('To', $this->headers->encode($name) ." <$mail>");
        }
        else {
            $this->recipients[] = $mail;
            $this->headers->add('To', $mail);
        }

        return $this;
    }

    public function addCopyTo($mail, $name = null)
    {
        if ( $name ) {
            $this->copyTo[] = $this->headers->encode($name) ." <$mail>";
            $this->headers->add('Cc', $this->headers->encode($name) ." <$mail>");
        }
        else {
            $this->hiddenCopy[] = $mail;
            $this->headers->add('Cc', $mail);
        }

        return $this;
    }
    
    public function addReplyTo($mail, $name = null)
    {
        if ($name) {
            $this->replyTo[] = $this->headers->encode($name) ." <$mail>";
        }
        else {
            $this->replyTo[] = $mail;
        }
        
        $this->headers->set('Reply-To', join(', ', $this->replyTo));

        return $this;
    }

    public function addHiddenCopy($mail, $name = null)
    {
        if ( $name ) {
            $this->hiddenCopy[] = $this->headers->encode($name) ." <$mail>";
            $this->headers->add('Bcc', $this->headers->encode($name) ." <$mail>");
        }
        else {
            $this->hiddenCopy[] = $mail;
            $this->headers->add('Bcc', $mail);
        }

        return $this;
    }

    public function addRelatedString($data, $id, $contentType = null)
    {
        if ( is_null($contentType) ) {
            $contentType = finfo_buffer(finfo_open(FILEINFO_MIME), $data);
        }

        $part = new Part();
        $this->related[] = $part;

        $part->setContentType($contentType)
            ->setContentDisposition('inline')
            ->setContentId($id)
            ->setContent($data)
        ;

        return $this;
    }

    public function addRelatedFile($path, $id = null, $contentType = null)
    {
        if ( is_null($id) ) {
            $id = basename($path);
        }

        if ( is_null($contentType) ) {
            $contentType = finfo_file(finfo_open(FILEINFO_MIME), $path);
        }

        $part = new Part();
        $this->related[] = $part;

        $part->setContentType($contentType)
            ->setContentDisposition('inline')
            ->setContentId($id)
            ->includeContent($path)
        ;

        return $this;
    }

    public function addAttachmentString($data, $fileName, $contentType = null)
    {
        if ( is_null($contentType) ) {
            $contentType = finfo_buffer(finfo_open(FILEINFO_MIME), $data);
        }

        $part = new Part();
        $this->attachments[] = $part;

        $part->setContentType($contentType)
            ->setContentDisposition('attachment; filename="'.$this->headers->encode($fileName) .'"')
            ->setContent($data)
        ;

        return $this;
    }

    public function addAttachmentFile($path, $fileName = null, $contentType = null)
    {
        if ( is_null($fileName) ) {
            $fileName = basename($path);
        }

        if ( is_null($contentType) ) {
            $contentType = finfo_file(finfo_open(FILEINFO_MIME), $path);
        }

        $part = new Part();
        $this->attachments[] = $part;

        $part->setContentType($contentType)
            ->setContentDisposition('attachment; filename="'. $this->headers->encode($fileName) .'"')
            ->includeContent($path)
        ;

        return $this;
    }

    public function getId()
    {
        return $this->headers->getFirst('Message-ID');
    }

    public function getRecipients($separator = null)
    {
        $recipients = array_merge($this->recipients, $this->copyTo, $this->hiddenCopy);

        // Если адреса кривые, можно расскомментировать следующую строку. Там не менее кривая функция, которая исправляет кривые адреса.
        // $recipients = Functions::mail2array($recipients);

        if ( isset($separator) ) {
            return join($separator, $recipients);
        }

        return $recipients;
    }

    public function getRecipientsEmailOnly()
    {
        return Functions::mail2array($this->getRecipients());
    }

    public function setSenderEmail($email, $name = null)
    {
        $this->senderEmail = $email;

        if ( $name ) {
            $this->headers->set('From', $this->headers->encode($name) ." <$email>");
        }
        else {
            $this->headers->set('From', "<$email>");
        }

        return $this;
    }

    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    public function __toString()
    {
        return $this->toEml();
    }

    public function toEml()
    {
        // Объявляем части письма
        $message = $this->content;

        if ( $this->related ) {
            $related = new MultiPart('related');
            $related->addPart($message);

            foreach ( $this->related as $part ) {
                $related->addPart($part);
            }

            $message = $related;
        }

        if ( $this->content->isHtml() ) {
            $alternative = new MultiPart('alternative');

            $alternativeText = new Part();

            $text = preg_replace('/^[\s\S]*<body[^>]*>/i', '', $this->content->getContent());
            $text = preg_replace('/<a[^>]+href=[\'"]([^>]+)[\'"][^>]*>([^>]*)<\\/a>/', '$2 $1', $text);
            $text = trim(strip_tags($text));

            $alternativeText->setContentType('text/plain; charset='. $this->charset);
            $alternativeText->setContent($text);

            $alternative->addPart($alternativeText);
            $alternative->addPart($message);

            $message = $alternative;
        }

        if ( $this->attachments ) {
            $mixed = new MultiPart('mixed');
            $mixed->addPart($message);

            foreach ( $this->attachments as $part ) {
                $mixed->addPart($part);
            }

            $message = $mixed;
        }

        return $this->headers . $message;
    }
}
