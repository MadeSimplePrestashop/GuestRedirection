<?php

/*
 * Guest redirection - a module for Prestashop v1.6
 * Copyright (C) kuzmany.biz/prestashop
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('_PS_VERSION_'))
    exit;

class GuestRedirection extends Module {

    public function __construct() {
        $this->name = 'guestredirection';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'kuzmany.biz';
        $this->need_instance = 0;
        $this->trusted = 1;

        parent::__construct();

        $this->displayName = $this->l('Guest redirection');
        $this->description = $this->l('Redirect quest to carriers step');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    /**
     * install
     */
    public function install() {

        if (!parent::install() ||
                !$this->registerHook('actionCustomerAccountAdd') || !$this->registerHook('displayFooter'))
            return false;
        return true;
    }

    /**
     * uninstall
     */
    public function uninstall() {
        if (!parent::uninstall())
            return false;
        return true;
    }

    public function hookActionCustomerAccountAdd($params) {
        if (isset($params['newCustomer']->is_guest) && $params['newCustomer']->is_guest == 1) {
            $link = $this->context->link;
            $url = $link->getPageLink('order', true, NULL, "step=1&new_user_created");
            Tools::redirect($url);
        }
    }

    public function hookDisplayFooter($params) {
        if (Tools::getIsset('new_user_created')) {
            $link = $this->context->link;
            $url = $link->getPageLink('order', true, NULL, "step=2");
            Tools::redirect($url);
        }
    }

}

?>
