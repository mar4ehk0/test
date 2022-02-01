<?php

class ArticleMapper
{
    private PDO $pdo;
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select id, titile, body, user_id, created from articles where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into articles (titile, body, user_id, created) values (?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update articles set titile = ?, body = ?, user_id = ?, created = ? where id = ?"
        );
    }

    /**
     * Finds Article by Article Id.
     *
     * @param int $id
     * @return Article|null
     */
    public function findById(int $id): ?Article
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if (empty($result)) {
            return null;
        }

        return new Article(
            $id,
            $result['title'],
            $result['body'],
            $result['userId'],
            $result['created']
        );
    }

    /**
     * Creates new rows in DB.
     * Use this command you can create new Article for Author (User).
     *
     * @param ArticleDTO $dto
     * @return Article
     */
    public function insert(ArticleDTO $dto): Article
    {
        $this->insertStmt->execute([
            $dto->title,
            $dto->body,
            $dto->userId,
            $dto->created,
        ]);

        return new Article(
            (int) $this->pdo->lastInsertId(),
                $dto->title,
            $dto->body,
            $dto->userId,
            $dto->created,
        );
    }

    /**
     * Updates Article.
     * Use this command you can change Author (User).
     *
     * @param Article $article
     * @return bool
     */
    public function update(Article $article): bool
    {
        return $this->updateStmt->execute([
            $article->getTitle(),
            $article->getBody(),
            $article->getUserId(),
            $article->getCreated(),
            $article->getId(),
        ]);
    }

    /**
     * Finds All articles by Author.
     * Use this command you can get all Articles by Author (User).
     *
     * @param User $user
     * @return ArticleCollection|null
     */
    public function getAllArticles(User $user): ?ArticleCollection
    {
        $stmt = $this->pdo->prepare(
            "select id, titile, body, user_id, created from articles where user_id = ?"
        );

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute([$user->getId()]);
        $raws = $stmt->fetchAll();

        if (empty($raws)) {
            return null;
        }

        return new ArticleCollection($raws);
    }


}