<?php
namespace Bag\LoginBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bag_login');

        $rootNode
          ->children()
            ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('email')
              ->isRequired()
              ->children()
                ->booleanNode('require_account_verification')->defaultFalse()->end()
                ->booleanNode('send_registration_email')->defaultTrue()->end()
                ->booleanNode('send_activation_email')->defaultTrue()->end()
                ->booleanNode('send_password_changed_email')->defaultFalse()->end()
                ->scalarNode('from_address')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('from_display_name')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('events')
                  ->children()
                    ->arrayNode('registration')
                      ->children()
                        ->enumNode('format')->values(array('html', 'text'))->defaultValue('html')->end()
                        ->scalarNode('subject')->defaultValue('Registration confirmed')->end()
                        ->scalarNode('view')->defaultValue('BagLoginBundle:Email:registration.html.twig')->end()
                      ->end()
                    ->end()
                    ->arrayNode('account_activation')
                      ->children()
                        ->enumNode('format')->values(array('html', 'text'))->defaultValue('html')->end()
                        ->scalarNode('subject')->defaultValue('Account activated')->end()
                        ->scalarNode('view')->defaultValue('BagLoginBundle:Email:account_activation.html.twig')->end()
                      ->end()
                    ->end()
                    ->arrayNode('request_new_password')
                      ->children()
                        ->enumNode('format')->values(array('html', 'text'))->defaultValue('html')->end()
                        ->scalarNode('subject')->defaultValue('A new password has been requested')->end()
                        ->scalarNode('view')->defaultValue('BagLoginBundle:Email:request_new_password.html.twig')->end()
                      ->end()
                    ->end()
                    ->arrayNode('password_changed')
                      ->children()
                        ->enumNode('format')->values(array('html', 'text'))->defaultValue('html')->end()
                        ->scalarNode('subject')->defaultValue('Password changed')->end()
                        ->scalarNode('view')->defaultValue('BagLoginBundle:Email:password_changed.html.twig')->end()
                      ->end()
                    ->end()
                  ->end()
                ->end()
              ->end()
            ->end()
            ->arrayNode('form')
              ->isRequired()
              ->children()
                ->arrayNode('type')
                  ->children()
                    ->scalarNode('registration')->defaultValue('Bag\LoginBundle\Form\Type\RegistrationType')->end()
                  ->end()
                ->end()
              ->end()
            ->end()
            ->arrayNode('social_network')
              ->children()
                ->arrayNode('facebook')
                  ->children()
                    ->scalarNode('appId')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
                  ->end()
                ->end()
                ->arrayNode('twitter')
                  ->children()
                    ->scalarNode('appId')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
                  ->end()
                ->end()
                ->arrayNode('google')
                  ->children()
                    ->scalarNode('appId')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
                  ->end()
                ->end()
              ->end()
            ->end()
            ->arrayNode('views')
              ->children()
                ->scalarNode('page_not_found')->defaultValue('BagLoginBundle:Default:page_not_found.html.twig')->end()
                ->scalarNode('error')->defaultValue('BagLoginBundle:Default:error.html.twig')->end()
                ->scalarNode('activation_email_request')->defaultValue('BagLoginBundle:Default:activation_email_request.html.twig')->end()
                ->scalarNode('activation_email_request_completed')->defaultValue('BagLoginBundle:Default:activation_email_request_completed.html.twig')->end()
                ->scalarNode('registration')->defaultValue('BagLoginBundle:Default:registration.html.twig')->end()
                ->scalarNode('registration_completed')->defaultValue('BagLoginBundle:Default:registration_completed.html.twig')->end()
                ->scalarNode('account_activated')->defaultValue('BagLoginBundle:Default:account_activated.html.twig')->end()
                ->scalarNode('login')->defaultValue('BagLoginBundle:Default:login.html.twig')->end()
                ->scalarNode('request_new_password')->defaultValue('BagLoginBundle:Default:request_new_password.html.twig')->end()
                ->scalarNode('request_new_password_completed')->defaultValue('BagLoginBundle:Default:request_new_password_completed.html.twig')->end()
                ->scalarNode('change_password')->defaultValue('BagLoginBundle:Default:change_password.html.twig')->end()
                ->scalarNode('change_password_completed')->defaultValue('BagLoginBundle:Default:change_password_completed.html.twig')->end()
              ->end()
            ->end()
          ->end();

        return $treeBuilder;
    }
}
