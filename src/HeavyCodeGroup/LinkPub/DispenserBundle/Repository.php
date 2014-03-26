<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle;

/**
 * Class Repository
 * @package HeavyCodeGroup\LinkPub\DispenserBundle
 *
 * This is not an ORM repository. Not uses Entity or EntityRepository namespace to avoid cognitive dissonance.
 */
class Repository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $guid
     * @return Site
     */
    public function getSiteByGuid($guid)
    {
        $sth = $this->pdo->prepare(
            'SELECT id, date_last_obtain, date_last_updated FROM site WHERE guid = :site_guid'
        );
        $sth->bindValue(':site_guid', $guid);
        $sth->execute();

        if ($row = $sth->fetch(\PDO::FETCH_NUM)) {
            $site = new Site($this);
            $site->setId($row[0])->setDateLastObtain($row[1])->setDateLastUpdated($row[2]);

            return $site;
        }

        return null;
    }

    /**
     * @param string $guid
     * @return Site
     */
    public function getSiteByConsumerInstanceGuid($guid)
    {
        $sth = $this->pdo->prepare(
            'SELECT
              site.id,
              site.date_last_obtain,
              site.date_last_updated
             FROM site
              INNER JOIN consumer_instance ON site.id = consumer_instance.site_id
             WHERE consumer_instance.guid = :consumer_instance_guid'
        );
        $sth->bindValue(':consumer_instance_guid', $guid);
        $sth->execute();

        if ($row = $sth->fetch(\PDO::FETCH_NUM)) {
            $site = new Site($this);
            $site->setId($row[0])->setDateLastObtain($row[1])->setDateLastUpdated($row[2]);

            return $site;
        }

        return null;
    }

    /**
     * @param Site $site
     * @return array
     */
    public function getLinkDataOfSite(Site $site)
    {
        $sth = $this->pdo->prepare(
            'SELECT
              page.id,
              page.url,
              link.url,
              link.title,
              link.description
             FROM link
              INNER JOIN page ON link.page_id = page.id
             WHERE page.site_id = :site_id AND link.state != :forbidden_state'
        );
        $sth->bindValue(':site_id', $site->getId(), \PDO::PARAM_INT);
        $sth->bindValue(':forbidden_state', 'sleeping');
        $sth->execute();

        $links = array();
        while ($row = $sth->fetch(\PDO::FETCH_NUM)) {
            if (!isset($links[$row[1]])) {
                $links[$row[1]] = array();
            }
            $links[$row[1]][] = array(
                'url' => $row[2],
                'title' => $row[3],
                'description' => $row[4],
            );
        }

        return $links;
    }

    /**
     * @param string $guid
     * @return Consumer
     */
    public function getConsumerByGuid($guid)
    {
        $sth = $this->pdo->prepare(
            'SELECT id, status FROM consumer WHERE guid = :consumer_guid'
        );
        $sth->bindValue(':consumer_guid', $guid);
        $sth->execute();

        if ($row = $sth->fetch(\PDO::FETCH_NUM)) {
            $consumer = new Consumer($this);
            $consumer->setId($row[0])->setStatus($row[1]);

            return $consumer;
        }

        return null;
    }

    /**
     * @param string $guid
     * @return Consumer
     */
    public function getConsumerByInstanceGuid($guid)
    {
        $sth = $this->pdo->prepare(
            'SELECT
              consumer.id,
              consumer.status
             FROM consumer
              INNER JOIN consumer_instance ON consumer.id = consumer_instance.consumer_id
             WHERE consumer_instance.guid = :instance_guid'
        );
        $sth->bindValue(':instance_guid', $guid);
        $sth->execute();

        if ($row = $sth->fetch(\PDO::FETCH_NUM)) {
            $consumer = new Consumer($this);
            $consumer->setId($row[0])->setStatus($row[1]);

            return $consumer;
        }

        return null;
    }

    public function concludeUserRequest(Site $site, Consumer $consumer)
    {
        $sth = $this->pdo->prepare('UPDATE site SET
         date_last_obtain = :date_last_obtain,
         is_using_deprecated_consumer = :is_using_deprecated_consumer
        WHERE id = :id');

        $now = new \DateTime();
        $sth->bindValue(':date_last_obtain', $now->format('Y-m-d H:i:s'));
        $sth->bindValue(':is_using_deprecated_consumer', $consumer->isDeprecated());
        $sth->bindValue(':id', $site->getId());
        $sth->execute();
    }
}
