<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 15:20
 */

namespace Thomblin\Whatsapp\Repository;

use PDOStatement;
use Thomblin\Whatsapp\Db\Model\Message;

class Messages extends Repository
{
    /**
     * @param Message $message
     * @return PDOStatement
     */
    public function storeMessage(Message $message)
    {
        static $stmt = null;

        if (null === $stmt) {
            $stmt = $this->pdo->prepare("
              INSERT INTO messages
                (`protocol`, `msg_id`, `from`, `to`, `nickname`, `time`, `type`, `body`)
                VALUES
                (:protocol, :msgId, :from, :to, :nickname, :time, :type, :body)"
            );
        }

        return $stmt->execute([
            'protocol' => $message->protocol,
            'msgId' => $message->msgId,
            'from' => $message->from,
            'to' => $message->to,
            'nickname' => $message->nickname,
            'time' => $message->time,
            'type' => $message->type,
            'body' => $message->body,
        ]);
    }

    /**
     * @param int $protocol
     * @param string $username
     * @return array
     */
    public function getUnsentMessages($protocol, $username)
    {
        return $this->pdo->fetchAll("
            SELECT
              `id`, `to`, `type`, `body`
            FROM
              `messages`
            WHERE
                `protocol` = ? AND
                `new` = ? AND
                `from`= ?
            ORDER BY `id` ASC
            ",
            [$protocol, 1, $username]
        );
    }

    /**
     * @param int $id
     * @param string $msgId
     * @return bool
     */
    public function markMessageSent($id, $msgId)
    {
        static $stmt = null;

        if (null === $stmt) {
            $stmt = $this->pdo->prepare("
                UPDATE
                  messages
                SET
                  `new`=0,
                  `msg_id`=:msgID,
                  `time`=NOW()
                WHERE
                  `id`=:id"
            );
        }

        return $stmt->execute(['id' => $id, 'msgID' => $msgId]);
    }

    /**
     * prepare a message to be sent by daemon later
     *
     * @param Message $message
     * @return string
     */
    public function createMessage(Message $message)
    {
        $this->pdo->execute("
          INSERT INTO messages
            (`protocol`, `msg_id`, `from`, `to`, `nickname`, `time`, `type`, `body`)
            VALUES
            (:protocol, NULL, :from, :to, :nickname, NOW(), 'text', :body)",
            array(
                'protocol' => Credentials::PROTOCOL_WHATSAPP,
                'from' => $message->from,
                'nickname' => $message->nickname,
                'to' => $message->to,
                'body' => $message->body
            )
        );

        return $this->pdo->lastInsertId();
    }

    /**
     * @param int $protocol
     * @param string $username
     * @return array
     */
    public function getUnreadMessages($protocol, $username)
    {
        return $this->pdo->fetchAll("
                SELECT
                  *
                FROM
                  messages
                WHERE
                  `protocol` = ? AND
                  `new` = 1 AND
                  `to` = ?
            ",
            array($protocol, $username)
        );
    }

    /**
     * @param int[] $ids
     * @return bool
     */
    public function markMessagesRead(array $ids)
    {
        return $this->pdo->execute("
                UPDATE
                  messages
                SET
                  `new`=0
                WHERE `id` IN (" . implode(',', array_fill(0, count($ids), '?')) . ")",
            $ids
        );
    }
}