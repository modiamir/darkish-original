<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/hello')) {
            // darkish_panel_homepage
            if (preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'darkish_panel_homepage')), array (  '_controller' => 'Darkish\\PanelBundle\\Controller\\DefaultController::indexAction',));
            }

            // darkish_category_homepage
            if (preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'darkish_category_homepage')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\DefaultController::indexAction',));
            }

        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/news')) {
                if (0 === strpos($pathinfo, '/admin/newstree')) {
                    // darkish_newstree_gettreejson
                    if ($pathinfo === '/admin/newstree/getjsontree') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::getJsonTreeAction',  '_route' => 'darkish_newstree_gettreejson',);
                    }

                    // admin_newstree
                    if (rtrim($pathinfo, '/') === '/admin/newstree') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_newstree;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'admin_newstree');
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::indexAction',  '_route' => 'admin_newstree',);
                    }
                    not_admin_newstree:

                    // admin_newstree_create
                    if ($pathinfo === '/admin/newstree/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_admin_newstree_create;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::createAction',  '_route' => 'admin_newstree_create',);
                    }
                    not_admin_newstree_create:

                    // admin_newstree_new
                    if ($pathinfo === '/admin/newstree/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_newstree_new;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::newAction',  '_route' => 'admin_newstree_new',);
                    }
                    not_admin_newstree_new:

                    // admin_newstree_show
                    if (preg_match('#^/admin/newstree/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_newstree_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_newstree_show')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::showAction',));
                    }
                    not_admin_newstree_show:

                    // admin_newstree_edit
                    if (preg_match('#^/admin/newstree/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_newstree_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_newstree_edit')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::editAction',));
                    }
                    not_admin_newstree_edit:

                    // admin_newstree_update
                    if (preg_match('#^/admin/newstree/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_admin_newstree_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_newstree_update')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::updateAction',));
                    }
                    not_admin_newstree_update:

                    // admin_newstree_delete
                    if (preg_match('#^/admin/newstree/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_admin_newstree_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_newstree_delete')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::deleteAction',));
                    }
                    not_admin_newstree_delete:

                    // admin_newstree_addnews
                    if (preg_match('#^/admin/newstree/(?P<id>[^/]++)/add$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_newstree_addnews')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsTreeController::addNewsAction',));
                    }

                }

                // news
                if (rtrim($pathinfo, '/') === '/admin/news') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'news');
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::indexAction',  '_route' => 'news',);
                }

                if (0 === strpos($pathinfo, '/admin/news/ajax')) {
                    if (0 === strpos($pathinfo, '/admin/news/ajax/get')) {
                        if (0 === strpos($pathinfo, '/admin/news/ajax/gettree')) {
                            // news_get_tree
                            if ($pathinfo === '/admin/news/ajax/gettree') {
                                return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getTreeAction',  '_format' => 'json',  '_route' => 'news_get_tree',);
                            }

                            // news_get_tree_linear
                            if ($pathinfo === '/admin/news/ajax/gettree_linear') {
                                return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getTreeLinearAction',  '_format' => 'json',  '_route' => 'news_get_tree_linear',);
                            }

                        }

                        // news_get_json
                        if ($pathinfo === '/admin/news/ajax/getjson') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getJsonAction',  '_format' => 'json',  '_route' => 'news_get_json',);
                        }

                        // news_get_news_for_category
                        if (0 === strpos($pathinfo, '/admin/news/ajax/get_news_for_cat') && preg_match('#^/admin/news/ajax/get_news_for_cat/(?P<cid>[^/]++)(?:/(?P<count>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_get_news_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getNewsForCategoryAction',  '_format' => 'json',  'count' => 0,));
                        }

                    }

                    // news_search_news
                    if (0 === strpos($pathinfo, '/admin/news/ajax/search_news') && preg_match('#^/admin/news/ajax/search_news/(?P<search_by>[^/]++)/(?P<sort_by>[^/]++)/(?P<count>[^/]++)(?:/(?P<keyword>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_search_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::searchNewssAction',  '_format' => 'json',  'keyword' => '',  'search_by' => 1,  'sort_by' => 1,));
                    }

                    // news_verify_news
                    if (0 === strpos($pathinfo, '/admin/news/ajax/verify_news') && preg_match('#^/admin/news/ajax/verify_news/(?P<newsId>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_news_verify_news;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_verify_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::verifyNewsAction',  '_format' => 'json',));
                    }
                    not_news_verify_news:

                    if (0 === strpos($pathinfo, '/admin/news/ajax/toggle_')) {
                        // news_toggle_verify_news
                        if (0 === strpos($pathinfo, '/admin/news/ajax/toggle_verify_news') && preg_match('#^/admin/news/ajax/toggle_verify_news/(?P<newsId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                                $allow = array_merge($allow, array('POST', 'PUT'));
                                goto not_news_toggle_verify_news;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_toggle_verify_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::toggleVerifyNewsAction',  '_format' => 'json',));
                        }
                        not_news_toggle_verify_news:

                        // news_toggle_active_news
                        if (0 === strpos($pathinfo, '/admin/news/ajax/toggle_active_news') && preg_match('#^/admin/news/ajax/toggle_active_news/(?P<newsId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                                $allow = array_merge($allow, array('POST', 'PUT'));
                                goto not_news_toggle_active_news;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_toggle_active_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::toggleActiveNewsAction',  '_format' => 'json',));
                        }
                        not_news_toggle_active_news:

                    }

                    // news_delete_news
                    if (0 === strpos($pathinfo, '/admin/news/ajax/delete_news') && preg_match('#^/admin/news/ajax/delete_news/(?P<newsId>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_news_delete_news;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_delete_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::deleteNewsAction',  '_format' => 'json',));
                    }
                    not_news_delete_news:

                    if (0 === strpos($pathinfo, '/admin/news/ajax/get_')) {
                        // news_get_news
                        if (0 === strpos($pathinfo, '/admin/news/ajax/get_news') && preg_match('#^/admin/news/ajax/get_news/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_get_news')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getNewsAction',  '_format' => 'json',));
                        }

                        // news_get_centers
                        if ($pathinfo === '/admin/news/ajax/get_centers') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getCentersAction',  '_format' => 'json',  '_route' => 'news_get_centers',);
                        }

                        // news_get_safarsaz_types
                        if ($pathinfo === '/admin/news/ajax/get_safarsaz_types') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getSafarsazTypesAction',  '_format' => 'json',  '_route' => 'news_get_safarsaz_types',);
                        }

                        // news_get_dbase_types
                        if ($pathinfo === '/admin/news/ajax/get_dbase_types') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getDbaseTypesAction',  '_format' => 'json',  '_route' => 'news_get_dbase_types',);
                        }

                        // news_get_areas
                        if ($pathinfo === '/admin/news/ajax/get_areas') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getAreasAction',  '_format' => 'json',  '_route' => 'news_get_areas',);
                        }

                    }

                    // news_update
                    if (preg_match('#^/admin/news/ajax/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_news_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_update')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::updateAction',));
                    }
                    not_news_update:

                    // news_create
                    if ($pathinfo === '/admin/news/ajax/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_news_create;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::createAction',  '_route' => 'news_create',);
                    }
                    not_news_create:

                    // news_get_generate_csrf
                    if ($pathinfo === '/admin/news/ajax/generate_csrf') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::generateCsrfAction',  '_format' => 'json',  '_route' => 'news_get_generate_csrf',);
                    }

                    // news_contains_tree
                    if (0 === strpos($pathinfo, '/admin/news/ajax/contains_tree') && preg_match('#^/admin/news/ajax/contains_tree/(?P<newsId>[^/]++)/(?P<treeId>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_contains_tree')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::containsTreeAction',  '_format' => 'json',));
                    }

                    // news_access_test
                    if ($pathinfo === '/admin/news/ajax/access') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::accessAction',  '_format' => 'json',  '_route' => 'news_access_test',);
                    }

                    if (0 === strpos($pathinfo, '/admin/news/ajax/get_')) {
                        // news_get_username
                        if ($pathinfo === '/admin/news/ajax/get_username') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getUsernameAction',  '_format' => 'json',  '_route' => 'news_get_username',);
                        }

                        // news_get_last_newsnumber
                        if ($pathinfo === '/admin/news/ajax/get_last_newsnumber') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::getLastNewsNumberAction',  '_format' => 'json',  '_route' => 'news_get_last_newsnumber',);
                        }

                    }

                    // news_lock_news_number
                    if (0 === strpos($pathinfo, '/admin/news/ajax/lock_news_number') && preg_match('#^/admin/news/ajax/lock_news_number/(?P<newsNumber>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_news_lock_news_number;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_lock_news_number')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::lockNewsNumberAction',  '_format' => 'json',));
                    }
                    not_news_lock_news_number:

                    // news_check_permission
                    if (0 === strpos($pathinfo, '/admin/news/ajax/check_permission') && preg_match('#^/admin/news/ajax/check_permission/(?P<attribute>[^/]++)(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'news_check_permission')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\NewsController::checkPermissionAction',  '_format' => 'json',  'id' => NULL,));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/offer')) {
                // offer
                if (rtrim($pathinfo, '/') === '/admin/offer') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'offer');
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::indexAction',  '_route' => 'offer',);
                }

                // offer_show
                if (preg_match('#^/admin/offer/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_show')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::showAction',));
                }

                // offer_new
                if ($pathinfo === '/admin/offer/new') {
                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::newAction',  '_route' => 'offer_new',);
                }

                if (0 === strpos($pathinfo, '/admin/offer/ajax')) {
                    // offer_create
                    if ($pathinfo === '/admin/offer/ajax/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_offer_create;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::createAction',  '_route' => 'offer_create',);
                    }
                    not_offer_create:

                    // offer_edit
                    if (0 === strpos($pathinfo, '/admin/offer/ajax/edit') && preg_match('#^/admin/offer/ajax/edit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_offer_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_edit')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::editAction',));
                    }
                    not_offer_edit:

                    // offer_approve
                    if (0 === strpos($pathinfo, '/admin/offer/ajax/offer/approve') && preg_match('#^/admin/offer/ajax/offer/approve/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_offer_approve;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_approve')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::approveAction',));
                    }
                    not_offer_approve:

                }

                // offer_update
                if (preg_match('#^/admin/offer/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_offer_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_update')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::updateAction',));
                }
                not_offer_update:

                if (0 === strpos($pathinfo, '/admin/offer/ajax')) {
                    // offer_delete
                    if (0 === strpos($pathinfo, '/admin/offer/ajax/offer/delete') && preg_match('#^/admin/offer/ajax/offer/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                            $allow = array_merge($allow, array('POST', 'DELETE'));
                            goto not_offer_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_delete')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::deleteAction',));
                    }
                    not_offer_delete:

                    if (0 === strpos($pathinfo, '/admin/offer/ajax/ge')) {
                        if (0 === strpos($pathinfo, '/admin/offer/ajax/get')) {
                            if (0 === strpos($pathinfo, '/admin/offer/ajax/gettree')) {
                                // offer_get_tree
                                if ($pathinfo === '/admin/offer/ajax/gettree') {
                                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::getTreeAction',  '_format' => 'json',  '_route' => 'offer_get_tree',);
                                }

                                // offer_get_tree_linear
                                if ($pathinfo === '/admin/offer/ajax/gettree_linear') {
                                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::getTreeLinearAction',  '_format' => 'json',  '_route' => 'offer_get_tree_linear',);
                                }

                            }

                            if (0 === strpos($pathinfo, '/admin/offer/ajax/get_')) {
                                // offer_get_offer_for_category
                                if (0 === strpos($pathinfo, '/admin/offer/ajax/get_offer_for_cat') && preg_match('#^/admin/offer/ajax/get_offer_for_cat/(?P<cid>[^/]++)(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_get_offer_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::getofferForCategoryAction',  '_format' => 'json',  'page' => 1,));
                                }

                                // offer_total_pages_for_category
                                if (0 === strpos($pathinfo, '/admin/offer/ajax/get_total_pages') && preg_match('#^/admin/offer/ajax/get_total_pages/(?P<cid>[^/]++)$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_total_pages_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::getTotalPagesForCatAction',  '_format' => 'json',));
                                }

                            }

                        }

                        // offer_get_generate_csrf
                        if (0 === strpos($pathinfo, '/admin/offer/ajax/generate_csrf') && preg_match('#^/admin/offer/ajax/generate_csrf(?:/(?P<intention>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_get_generate_csrf')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::generateCsrfAction',  '_format' => 'json',  'intention' => '',));
                        }

                    }

                    // offer_get_is_csrf_valid
                    if (0 === strpos($pathinfo, '/admin/offer/ajax/is_csrf_valid') && preg_match('#^/admin/offer/ajax/is_csrf_valid/(?P<token>[^/]++)(?:/(?P<intention>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_get_is_csrf_valid')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::isCsrfValidAction',  '_format' => 'json',  'intention' => '',));
                    }

                    // offer_get_offer
                    if (0 === strpos($pathinfo, '/admin/offer/ajax/get_offer') && preg_match('#^/admin/offer/ajax/get_offer/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'offer_get_offer')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\OfferController::getofferAction',  '_format' => 'json',  'intention' => '',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/classified')) {
                // classified
                if (rtrim($pathinfo, '/') === '/admin/classified') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'classified');
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::indexAction',  '_route' => 'classified',);
                }

                // classified_show
                if (preg_match('#^/admin/classified/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_show')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::showAction',));
                }

                // classified_new
                if ($pathinfo === '/admin/classified/new') {
                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::newAction',  '_route' => 'classified_new',);
                }

                if (0 === strpos($pathinfo, '/admin/classified/ajax')) {
                    // classified_create
                    if ($pathinfo === '/admin/classified/ajax/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_classified_create;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::createAction',  '_route' => 'classified_create',);
                    }
                    not_classified_create:

                    // classified_edit
                    if (0 === strpos($pathinfo, '/admin/classified/ajax/edit') && preg_match('#^/admin/classified/ajax/edit/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_classified_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_edit')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::editAction',));
                    }
                    not_classified_edit:

                    // classified_approve
                    if (0 === strpos($pathinfo, '/admin/classified/ajax/classified/approve') && preg_match('#^/admin/classified/ajax/classified/approve/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_classified_approve;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_approve')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::approveAction',));
                    }
                    not_classified_approve:

                }

                // classified_update
                if (preg_match('#^/admin/classified/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_classified_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_update')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::updateAction',));
                }
                not_classified_update:

                if (0 === strpos($pathinfo, '/admin/classified/ajax')) {
                    // classified_delete
                    if (0 === strpos($pathinfo, '/admin/classified/ajax/classified/delete') && preg_match('#^/admin/classified/ajax/classified/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                            $allow = array_merge($allow, array('POST', 'DELETE'));
                            goto not_classified_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_delete')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::deleteAction',));
                    }
                    not_classified_delete:

                    if (0 === strpos($pathinfo, '/admin/classified/ajax/ge')) {
                        if (0 === strpos($pathinfo, '/admin/classified/ajax/get')) {
                            if (0 === strpos($pathinfo, '/admin/classified/ajax/gettree')) {
                                // classified_get_tree
                                if ($pathinfo === '/admin/classified/ajax/gettree') {
                                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::getTreeAction',  '_format' => 'json',  '_route' => 'classified_get_tree',);
                                }

                                // classified_get_tree_linear
                                if ($pathinfo === '/admin/classified/ajax/gettree_linear') {
                                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::getTreeLinearAction',  '_format' => 'json',  '_route' => 'classified_get_tree_linear',);
                                }

                            }

                            if (0 === strpos($pathinfo, '/admin/classified/ajax/get_')) {
                                // classified_get_classified_for_category
                                if (0 === strpos($pathinfo, '/admin/classified/ajax/get_classified_for_cat') && preg_match('#^/admin/classified/ajax/get_classified_for_cat/(?P<cid>[^/]++)(?:/(?P<page>[^/]++))?$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_get_classified_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::getclassifiedForCategoryAction',  '_format' => 'json',  'page' => 1,));
                                }

                                // classified_total_pages_for_category
                                if (0 === strpos($pathinfo, '/admin/classified/ajax/get_total_pages') && preg_match('#^/admin/classified/ajax/get_total_pages/(?P<cid>[^/]++)$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_total_pages_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::getTotalPagesForCatAction',  '_format' => 'json',));
                                }

                            }

                        }

                        // classified_get_generate_csrf
                        if (0 === strpos($pathinfo, '/admin/classified/ajax/generate_csrf') && preg_match('#^/admin/classified/ajax/generate_csrf(?:/(?P<intention>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_get_generate_csrf')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::generateCsrfAction',  '_format' => 'json',  'intention' => '',));
                        }

                    }

                    // classified_get_is_csrf_valid
                    if (0 === strpos($pathinfo, '/admin/classified/ajax/is_csrf_valid') && preg_match('#^/admin/classified/ajax/is_csrf_valid/(?P<token>[^/]++)(?:/(?P<intention>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_get_is_csrf_valid')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::isCsrfValidAction',  '_format' => 'json',  'intention' => '',));
                    }

                    // classified_get_classified
                    if (0 === strpos($pathinfo, '/admin/classified/ajax/get_classified') && preg_match('#^/admin/classified/ajax/get_classified/(?P<id>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'classified_get_classified')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ClassifiedController::getclassifiedAction',  '_format' => 'json',  'intention' => '',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/managedfile/ajax')) {
                // managedfile
                if ($pathinfo === '/admin/managedfile/ajax/upload') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_managedfile;
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ManagedFileController::uploadAction',  '_route' => 'managedfile',);
                }
                not_managedfile:

                // managedfile_gen_rand_upload_key
                if ($pathinfo === '/admin/managedfile/ajax/gen_rand_upload_key') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_managedfile_gen_rand_upload_key;
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ManagedFileController::generateRandomUploadKeyAction',  '_route' => 'managedfile_gen_rand_upload_key',);
                }
                not_managedfile_gen_rand_upload_key:

                // managedfile_set_temporary_tuhmbnail
                if ($pathinfo === '/admin/managedfile/ajax/set_temporary_thumbnail') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_managedfile_set_temporary_tuhmbnail;
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ManagedFileController::setTemporaryThumbnailAction',  '_route' => 'managedfile_set_temporary_tuhmbnail',);
                }
                not_managedfile_set_temporary_tuhmbnail:

            }

            if (0 === strpos($pathinfo, '/admin/record')) {
                // record
                if (rtrim($pathinfo, '/') === '/admin/record') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'record');
                    }

                    return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::indexAction',  '_route' => 'record',);
                }

                if (0 === strpos($pathinfo, '/admin/record/ajax')) {
                    if (0 === strpos($pathinfo, '/admin/record/ajax/get')) {
                        if (0 === strpos($pathinfo, '/admin/record/ajax/gettree')) {
                            // record_get_tree
                            if ($pathinfo === '/admin/record/ajax/gettree') {
                                return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getTreeAction',  '_format' => 'json',  '_route' => 'record_get_tree',);
                            }

                            // record_get_tree_linear
                            if ($pathinfo === '/admin/record/ajax/gettree_linear') {
                                return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getTreeLinearAction',  '_format' => 'json',  '_route' => 'record_get_tree_linear',);
                            }

                        }

                        // record_get_json
                        if ($pathinfo === '/admin/record/ajax/getjson') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getJsonAction',  '_format' => 'json',  '_route' => 'record_get_json',);
                        }

                        // record_get_record_for_category
                        if (0 === strpos($pathinfo, '/admin/record/ajax/get_record_for_cat') && preg_match('#^/admin/record/ajax/get_record_for_cat/(?P<cid>[^/]++)(?:/(?P<count>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_get_record_for_category')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getRecordForCategoryAction',  '_format' => 'json',  'count' => 0,));
                        }

                    }

                    // record_search_record
                    if (0 === strpos($pathinfo, '/admin/record/ajax/search_record') && preg_match('#^/admin/record/ajax/search_record/(?P<search_by>[^/]++)/(?P<sort_by>[^/]++)/(?P<count>[^/]++)(?:/(?P<keyword>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_search_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::searchRecordsAction',  '_format' => 'json',  'keyword' => '',  'search_by' => 1,  'sort_by' => 1,));
                    }

                    // record_verify_record
                    if (0 === strpos($pathinfo, '/admin/record/ajax/verify_record') && preg_match('#^/admin/record/ajax/verify_record/(?P<recordId>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_record_verify_record;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_verify_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::verifyRecordAction',  '_format' => 'json',));
                    }
                    not_record_verify_record:

                    if (0 === strpos($pathinfo, '/admin/record/ajax/toggle_')) {
                        // record_toggle_verify_record
                        if (0 === strpos($pathinfo, '/admin/record/ajax/toggle_verify_record') && preg_match('#^/admin/record/ajax/toggle_verify_record/(?P<recordId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                                $allow = array_merge($allow, array('POST', 'PUT'));
                                goto not_record_toggle_verify_record;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_toggle_verify_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::toggleVerifyRecordAction',  '_format' => 'json',));
                        }
                        not_record_toggle_verify_record:

                        // record_toggle_active_record
                        if (0 === strpos($pathinfo, '/admin/record/ajax/toggle_active_record') && preg_match('#^/admin/record/ajax/toggle_active_record/(?P<recordId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                                $allow = array_merge($allow, array('POST', 'PUT'));
                                goto not_record_toggle_active_record;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_toggle_active_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::toggleActiveRecordAction',  '_format' => 'json',));
                        }
                        not_record_toggle_active_record:

                    }

                    // record_delete_record
                    if (0 === strpos($pathinfo, '/admin/record/ajax/delete_record') && preg_match('#^/admin/record/ajax/delete_record/(?P<recordId>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_record_delete_record;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_delete_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::deleteRecordAction',  '_format' => 'json',));
                    }
                    not_record_delete_record:

                    if (0 === strpos($pathinfo, '/admin/record/ajax/get_')) {
                        // record_get_record
                        if (0 === strpos($pathinfo, '/admin/record/ajax/get_record') && preg_match('#^/admin/record/ajax/get_record/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_get_record')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getRecordAction',  '_format' => 'json',));
                        }

                        // record_get_centers
                        if ($pathinfo === '/admin/record/ajax/get_centers') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getCentersAction',  '_format' => 'json',  '_route' => 'record_get_centers',);
                        }

                        // record_get_safarsaz_types
                        if ($pathinfo === '/admin/record/ajax/get_safarsaz_types') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getSafarsazTypesAction',  '_format' => 'json',  '_route' => 'record_get_safarsaz_types',);
                        }

                        // record_get_dbase_types
                        if ($pathinfo === '/admin/record/ajax/get_dbase_types') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getDbaseTypesAction',  '_format' => 'json',  '_route' => 'record_get_dbase_types',);
                        }

                        // record_get_areas
                        if ($pathinfo === '/admin/record/ajax/get_areas') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getAreasAction',  '_format' => 'json',  '_route' => 'record_get_areas',);
                        }

                    }

                    // record_update
                    if (preg_match('#^/admin/record/ajax/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_record_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_update')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::updateAction',));
                    }
                    not_record_update:

                    // record_create
                    if ($pathinfo === '/admin/record/ajax/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_record_create;
                        }

                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::createAction',  '_route' => 'record_create',);
                    }
                    not_record_create:

                    // record_get_generate_csrf
                    if ($pathinfo === '/admin/record/ajax/generate_csrf') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::generateCsrfAction',  '_format' => 'json',  '_route' => 'record_get_generate_csrf',);
                    }

                    // record_contains_tree
                    if (0 === strpos($pathinfo, '/admin/record/ajax/contains_tree') && preg_match('#^/admin/record/ajax/contains_tree/(?P<recordId>[^/]++)/(?P<treeId>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_contains_tree')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::containsTreeAction',  '_format' => 'json',));
                    }

                    // record_access_test
                    if ($pathinfo === '/admin/record/ajax/access') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::accessAction',  '_format' => 'json',  '_route' => 'record_access_test',);
                    }

                    if (0 === strpos($pathinfo, '/admin/record/ajax/get_')) {
                        // record_get_username
                        if ($pathinfo === '/admin/record/ajax/get_username') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getUsernameAction',  '_format' => 'json',  '_route' => 'record_get_username',);
                        }

                        // record_get_last_recordnumber
                        if ($pathinfo === '/admin/record/ajax/get_last_recordnumber') {
                            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::getLastRecordNumberAction',  '_format' => 'json',  '_route' => 'record_get_last_recordnumber',);
                        }

                    }

                    // record_lock_record_number
                    if (0 === strpos($pathinfo, '/admin/record/ajax/lock_record_number') && preg_match('#^/admin/record/ajax/lock_record_number/(?P<recordNumber>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_record_lock_record_number;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_lock_record_number')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::lockRecordNumberAction',  '_format' => 'json',));
                    }
                    not_record_lock_record_number:

                    // record_check_permission
                    if (0 === strpos($pathinfo, '/admin/record/ajax/check_permission') && preg_match('#^/admin/record/ajax/check_permission/(?P<attribute>[^/]++)(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'record_check_permission')), array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\RecordController::checkPermissionAction',  '_format' => 'json',  'id' => NULL,));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/user')) {
                if (0 === strpos($pathinfo, '/admin/user/ajax')) {
                    // user_logout
                    if ($pathinfo === '/admin/user/ajax/logout') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\UserController::logoutAction',  '_route' => 'user_logout',);
                    }

                    // user_is_logged_in
                    if ($pathinfo === '/admin/user/ajax/is_logged_in') {
                        return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\UserController::isLoggedInAction',  '_route' => 'user_is_logged_in',);
                    }

                }

                // user_admin_logout
                if ($pathinfo === '/admin/user/logout') {
                    return array('_route' => 'user_admin_logout');
                }

            }

        }

        // DarkishModi
        if ($pathinfo === '/modi/test') {
            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\DefaultController::testAction',  '_route' => 'DarkishModi',);
        }

        // managedfile_nervgh
        if ($pathinfo === '/nervgh') {
            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                goto not_managedfile_nervgh;
            }

            return array (  '_controller' => 'Darkish\\CategoryBundle\\Controller\\ManagedFileController::nervghAction',  '_route' => 'managedfile_nervgh',);
        }
        not_managedfile_nervgh:

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::loginAction',  '_route' => 'fos_user_security_login',);
                }

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::logoutAction',  '_route' => 'fos_user_security_logout',);
            }

            if (0 === strpos($pathinfo, '/login')) {
                // sonata_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::loginAction',  '_route' => 'sonata_user_security_login',);
                }

                // sonata_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_sonata_user_security_check;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::checkAction',  '_route' => 'sonata_user_security_check',);
                }
                not_sonata_user_security_check:

            }

            // sonata_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\SecurityFOSUser1Controller::logoutAction',  '_route' => 'sonata_user_security_logout',);
            }

        }

        if (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ($pathinfo === '/resetting/request') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_request;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::requestAction',  '_route' => 'fos_user_resetting_request',);
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_fos_user_resetting_send_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_check_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
            }
            not_fos_user_resetting_check_email:

            if (0 === strpos($pathinfo, '/resetting/re')) {
                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::resetAction',));
                }
                not_fos_user_resetting_reset:

                // sonata_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_sonata_user_resetting_request;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::requestAction',  '_route' => 'sonata_user_resetting_request',);
                }
                not_sonata_user_resetting_request:

            }

            // sonata_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_sonata_user_resetting_send_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::sendEmailAction',  '_route' => 'sonata_user_resetting_send_email',);
            }
            not_sonata_user_resetting_send_email:

            // sonata_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_sonata_user_resetting_check_email;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::checkEmailAction',  '_route' => 'sonata_user_resetting_check_email',);
            }
            not_sonata_user_resetting_check_email:

            // sonata_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_sonata_user_resetting_reset;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_user_resetting_reset')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ResettingFOSUser1Controller::resetAction',));
            }
            not_sonata_user_resetting_reset:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            if (0 === strpos($pathinfo, '/profile/edit-')) {
                // fos_user_profile_edit_authentication
                if ($pathinfo === '/profile/edit-authentication') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editAuthenticationAction',  '_route' => 'fos_user_profile_edit_authentication',);
                }

                // fos_user_profile_edit
                if ($pathinfo === '/profile/edit-profile') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editProfileAction',  '_route' => 'fos_user_profile_edit',);
                }

            }

            // sonata_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_sonata_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'sonata_user_profile_show');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::showAction',  '_route' => 'sonata_user_profile_show',);
            }
            not_sonata_user_profile_show:

            if (0 === strpos($pathinfo, '/profile/edit-')) {
                // sonata_user_profile_edit_authentication
                if ($pathinfo === '/profile/edit-authentication') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editAuthenticationAction',  '_route' => 'sonata_user_profile_edit_authentication',);
                }

                // sonata_user_profile_edit
                if ($pathinfo === '/profile/edit-profile') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ProfileFOSUser1Controller::editProfileAction',  '_route' => 'sonata_user_profile_edit',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if (rtrim($pathinfo, '/') === '/register') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::registerAction',  '_route' => 'fos_user_registration_register',);
            }

            if (0 === strpos($pathinfo, '/register/c')) {
                // fos_user_registration_check_email
                if ($pathinfo === '/register/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_registration_check_email;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                }
                not_fos_user_registration_check_email:

                if (0 === strpos($pathinfo, '/register/confirm')) {
                    // fos_user_registration_confirm
                    if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_confirm;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmAction',));
                    }
                    not_fos_user_registration_confirm:

                    // fos_user_registration_confirmed
                    if ($pathinfo === '/register/confirmed') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_confirmed;
                        }

                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                    }
                    not_fos_user_registration_confirmed:

                }

            }

            // sonata_user_registration_register
            if (rtrim($pathinfo, '/') === '/register') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'sonata_user_registration_register');
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::registerAction',  '_route' => 'sonata_user_registration_register',);
            }

            if (0 === strpos($pathinfo, '/register/c')) {
                // sonata_user_registration_check_email
                if ($pathinfo === '/register/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_sonata_user_registration_check_email;
                    }

                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::checkEmailAction',  '_route' => 'sonata_user_registration_check_email',);
                }
                not_sonata_user_registration_check_email:

                if (0 === strpos($pathinfo, '/register/confirm')) {
                    // sonata_user_registration_confirm
                    if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_sonata_user_registration_confirm;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'sonata_user_registration_confirm')), array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmAction',));
                    }
                    not_sonata_user_registration_confirm:

                    // sonata_user_registration_confirmed
                    if ($pathinfo === '/register/confirmed') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_sonata_user_registration_confirmed;
                        }

                        return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\RegistrationFOSUser1Controller::confirmedAction',  '_route' => 'sonata_user_registration_confirmed',);
                    }
                    not_sonata_user_registration_confirmed:

                }

            }

        }

        if (0 === strpos($pathinfo, '/profile/change-password')) {
            // fos_user_change_password
            if ($pathinfo === '/profile/change-password') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_change_password;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ChangePasswordFOSUser1Controller::changePasswordAction',  '_route' => 'fos_user_change_password',);
            }
            not_fos_user_change_password:

            // sonata_user_change_password
            if ($pathinfo === '/profile/change-password') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_sonata_user_change_password;
                }

                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\ChangePasswordFOSUser1Controller::changePasswordAction',  '_route' => 'sonata_user_change_password',);
            }
            not_sonata_user_change_password:

        }

        if (0 === strpos($pathinfo, '/admin/log')) {
            if (0 === strpos($pathinfo, '/admin/login')) {
                // sonata_user_admin_security_login
                if ($pathinfo === '/admin/login') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::loginAction',  '_route' => 'sonata_user_admin_security_login',);
                }

                // sonata_user_admin_security_check
                if ($pathinfo === '/admin/login_check') {
                    return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::checkAction',  '_route' => 'sonata_user_admin_security_check',);
                }

            }

            // sonata_user_admin_security_logout
            if ($pathinfo === '/admin/logout') {
                return array (  '_controller' => 'Sonata\\UserBundle\\Controller\\AdminSecurityController::logoutAction',  '_route' => 'sonata_user_admin_security_logout',);
            }

        }

        // fos_js_routing_js
        if (0 === strpos($pathinfo, '/js/routing') && preg_match('#^/js/routing(?:\\.(?P<_format>js|json))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_js_routing_js')), array (  '_controller' => 'fos_js_routing.controller:indexAction',  '_format' => 'js',));
        }

        if (0 === strpos($pathinfo, '/admin')) {
            // login_route
            if ($pathinfo === '/admin/operator/login') {
                return array (  '_controller' => 'Darkish\\UserBundle\\Controller\\OperatorController::loginAction',  '_route' => 'login_route',);
            }

            // security_remembered
            if ($pathinfo === '/admin/is_remembered') {
                return array (  '_controller' => 'Darkish\\UserBundle\\Controller\\OperatorController::isRememberedAction',  '_route' => 'security_remembered',);
            }

            if (0 === strpos($pathinfo, '/admin/operator')) {
                if (0 === strpos($pathinfo, '/admin/operator/log')) {
                    // login_check
                    if ($pathinfo === '/admin/operator/login_check') {
                        return array (  '_controller' => 'Darkish\\UserBundle\\Controller\\OperatorController::loginCheckAction',  '_route' => 'login_check',);
                    }

                    // logout
                    if ($pathinfo === '/admin/operator/logout') {
                        return array (  '_controller' => 'Darkish\\UserBundle\\Controller\\OperatorController::logoutAction',  '_route' => 'logout',);
                    }

                }

                // check_permission
                if ($pathinfo === '/admin/operator/check_permission') {
                    return array (  '_controller' => 'Darkish\\UserBundle\\Controller\\OperatorController::checkPermissionAction',  '_route' => 'check_permission',);
                }

            }

        }

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\WelcomeController::indexAction',  '_route' => '_welcome',);
        }

        if (0 === strpos($pathinfo, '/demo')) {
            if (0 === strpos($pathinfo, '/demo/secured')) {
                if (0 === strpos($pathinfo, '/demo/secured/log')) {
                    if (0 === strpos($pathinfo, '/demo/secured/login')) {
                        // _demo_login
                        if ($pathinfo === '/demo/secured/login') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  '_route' => '_demo_login',);
                        }

                        // _demo_security_check
                        if ($pathinfo === '/demo/secured/login_check') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  '_route' => '_demo_security_check',);
                        }

                    }

                    // _demo_logout
                    if ($pathinfo === '/demo/secured/logout') {
                        return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  '_route' => '_demo_logout',);
                    }

                }

                if (0 === strpos($pathinfo, '/demo/secured/hello')) {
                    // acme_demo_secured_hello
                    if ($pathinfo === '/demo/secured/hello') {
                        return array (  'name' => 'World',  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  '_route' => 'acme_demo_secured_hello',);
                    }

                    // _demo_secured_hello
                    if (preg_match('#^/demo/secured/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',));
                    }

                    // _demo_secured_hello_admin
                    if (0 === strpos($pathinfo, '/demo/secured/hello/admin') && preg_match('#^/demo/secured/hello/admin/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello_admin')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',));
                    }

                }

            }

            // _demo
            if (rtrim($pathinfo, '/') === '/demo') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_demo');
                }

                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  '_route' => '_demo',);
            }

            // _demo_hello
            if (0 === strpos($pathinfo, '/demo/hello') && preg_match('#^/demo/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',));
            }

            // _demo_contact
            if ($pathinfo === '/demo/contact') {
                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  '_route' => '_demo_contact',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
