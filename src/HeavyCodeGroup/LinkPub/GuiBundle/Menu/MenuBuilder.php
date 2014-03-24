<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        if (isset($options['class'])) {
            $menu->setChildrenAttribute('class', $options['class']);
        }

        $menu->addChild('linkpub.gui.dashboard', ['route' => 'linkpub_gui_client_dashboard']);
        $menu->addChild('linkpub.gui.sites', ['route' => 'linkpub_gui_client_sites']);
        $menu->addChild('linkpub.gui.incoming_links', ['route' => 'linkpub_gui_incoming_links']);
        $menu->addChild('linkpub.gui.outgoing_links', ['route' => 'linkpub_gui_outgoing_links']);

        return $menu;
    }
}
