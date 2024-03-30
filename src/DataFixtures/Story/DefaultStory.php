<?php

declare(strict_types=1);

namespace App\DataFixtures\Story;

use App\DataFixtures\Factory\BookFactory;
use App\DataFixtures\Factory\BookmarkFactory;
use App\DataFixtures\Factory\ReviewFactory;
use App\DataFixtures\Factory\UserFactory;
use App\Enum\BookCondition;
use App\Factory\ApiTokenFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Zenstruck\Foundry\Story;

final class DefaultStory extends Story {
    public function __construct(private readonly DecoderInterface $decoder, private UserPasswordHasherInterface $userPasswordHasherInterface, private EntityManagerInterface $entityManagerInterface) {
    }

    public function build(): void {
        // Create default book (must be created first to appear first in list)
        // $defaultBook = BookFactory::createOne([
        //     'condition' => BookCondition::UsedCondition,
        //     'book' => 'https://openlibrary.org/books/OL2055137M.json',
        //     'title' => 'Hyperion',
        //     'author' => 'Dan Simmons',
        // ]);

        // Default book has reviews (new users are created)
        // ReviewFactory::createMany(30, [
        //     'book' => $defaultBook,
        //     'publishedAt' => \DateTimeImmutable::createFromMutable(ReviewFactory::faker()->dateTime('-1 week')),
        // ]);

        // Import books
        // $books = []; // store books in array to pick 30 random ones later without the default one
        // $data = $this->decoder->decode(file_get_contents(__DIR__ . '/../books.json'), 'json');
        // foreach ($data as $datum) {
        //     $book = BookFactory::createOne($datum + [
        //         'condition' => BookCondition::cases()[array_rand(BookCondition::cases())],
        //     ]);

        //     // Optionally add reviews to it (create new users)
        //     if ($number = random_int(0, 5)) {
        //         ReviewFactory::createMany($number, [
        //             'book' => $book,
        //             'publishedAt' => \DateTimeImmutable::createFromMutable(ReviewFactory::faker()->dateTime('-1 week')),
        //         ]);
        //     }

        //     $books[] = $book;
        // }

        // Create default user
        $defaultUser = UserFactory::createOne([
            'username' => 'user',
            'email' => 'john.doe@example.com',
            'nombre' => 'John',
            'apellido' => 'Doe',
            'roles' => ['ROLE_USER'],
        ])->object();
        $defaultUser->setPassword($this->userPasswordHasherInterface->hashPassword($defaultUser, 'user'));

        // Default user has a review on the default book
        // ReviewFactory::createOne([
        //     'book' => $defaultBook,
        //     'user' => $defaultUser,
        //     'rating' => 5,
        //     'publishedAt' => new \DateTimeImmutable(),
        //     'body' => 'This is the best SF book ever!',
        // ]);

        // Default user has bookmarked the default book
        // BookmarkFactory::createOne([
        //     'book' => $defaultBook,
        //     'user' => $defaultUser,
        //     'bookmarkedAt' => new \DateTimeImmutable('-1 hour'),
        // ]);

        // Default user has bookmarked other books
        // foreach (array_rand($books, 30) as $key) {
        //     BookmarkFactory::createOne([
        //         'user' => $defaultUser,
        //         'book' => $books[$key],
        //         'bookmarkedAt' => \DateTimeImmutable::createFromMutable(BookmarkFactory::faker()->dateTime('-1 week')),
        //     ]);
        // }

        // Create admin user
        $defaultUser2 = UserFactory::createOne([
            'username' => 'admin',
            'email' => 'chuck.norris@example.com',
            'nombre' => 'Chuck',
            'apellido' => 'Norris',
            'roles' => ['ROLE_ADMIN'],
        ])->object();
        $defaultUser2->setPassword($this->userPasswordHasherInterface->hashPassword($defaultUser2, 'admin'));
        $this->entityManagerInterface->flush();

        ApiTokenFactory::createMany(30, function () {
            return [
                'Usuario' => UserFactory::random(),
            ];
        });
    }
}
