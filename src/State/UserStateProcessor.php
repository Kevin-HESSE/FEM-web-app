<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class UserStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: PersistProcessor::class )] private readonly ProcessorInterface $processor,
        private readonly UserPasswordHasherInterface                                       $userPasswordHasher,
        private readonly EmailVerifier                                                     $emailVerifier,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $data->setPassword(
            $this->userPasswordHasher->hashPassword(
                $data,
                $data->getPlainPassword()
            )
        );

        $result = $this->processor->process($data, $operation, $uriVariables, $context);

        $this->sendVerifyEmail($data);

        return $result;
    }

    private function sendVerifyEmail(User $user): void
    {
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('contact@webapp.io', 'Entertainment Web App'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('account/registration/confirmation_email.html.twig')
        );
    }
}
