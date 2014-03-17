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
        // TODO
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
}
