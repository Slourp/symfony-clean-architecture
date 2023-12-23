<?

namespace Tests\Feature\User\Repository;

use Faker\Factory as Faker;
use Infrastructure\Symfony\Entity\User;
use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;
use Domain\AuthContext\ValueObject\UserName;
use Domain\AuthContext\Entity\User as EntityUser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

uses(KernelTestCase::class);

beforeEach(function (): void {

    $kernel = KernelTestCase::bootKernel();
    $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    $this->userRepository = $this->entityManager->getRepository(User::class);
    $this->faker = Faker::create();
});

afterEach(function (): void {
    $this->entityManager->close();
    $this->entityManager = null;
});

it('registers a user', function () {
    $userRepo = $this->entityManager->getRepository(User::class);
    $initialUserCount = count($userRepo->findAll());
    $error = null;

    try {
        $userDomain = new EntityUser(
            password: Password::of("Chlo0204919/*--s@"),
            email: Email::of($this->faker->safeEmail()),
            userName: UserName::of($this->faker->userName())
        );

        $userRepo->registerUser($userDomain);
    } catch (\Exception $exception) {
        $error = $exception->getMessage();
    }

    // Validate new user count
    $finalUserCount = count($userRepo->findAll());
    expect($finalUserCount)->toBe($initialUserCount + 1, "Failed to register new user: $error");
});


it('finds user by username', function () {
    $userRepo = $this->entityManager->getRepository(User::class);
    $error = null;

    try {
        $userDomain = new EntityUser(
            password: Password::of("Chlo0204919/*--s@"),
            email: Email::of($this->faker->safeEmail()),
            userName: UserName::of($this->faker->userName())
        );

        $userRepo->registerUser($userDomain);
        $foundUser = $userRepo->findByUsername($userDomain->getUserName()->value);
    } catch (\Exception $exception) {
        $error = $exception->getMessage();
    }

    expect($error)->toBeNull();
    expect($foundUser)->not()->toBeNull();
    expect($foundUser->getUserName()->value)->toBe($userDomain->getUserName()->value);
});


it('checks if email exists', function () {
    $userRepo = $this->entityManager->getRepository(User::class);
    $error = null;

    try {
        $userDomain = new EntityUser(
            password: Password::of("Chlo0204919/*--s@"),
            email: Email::of($this->faker->safeEmail()),
            userName: UserName::of($this->faker->userName())
        );

        $userRepo->registerUser($userDomain);
        $emailExists = $userRepo->emailExists($userDomain->getEmail());
    } catch (\Exception $exception) {
        $error = $exception->getMessage();
    }

    expect($error)->toBeNull();
    expect($emailExists)->toBeTrue();
});
