<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers\Content\Category;

use helpers\Content\EmptySubCategory;
use helpers\Content\Guide;
use helpers\Content\RemoteLink;
use helpers\Content\UnlinkedCategory;

class DevelopInDepthCategory extends Category
{
    public function getName()
    {
        return 'Matomo In Depth';
    }

    public function getItems()
    {
        return [
            new Guide('piwik-in-depth-introduction'),
            new UnlinkedCategory('in-depth-understanding-piwik'),
            new EmptySubCategory('Matomo Core development', [
                new Guide('contributing-to-piwik-core'),
                new Guide('contributing-to-piwik-plugins'),
                new Guide('coding-standards'),
                new Guide('using-github-issues'),
                new Guide('pull-request-reviews'),
                new Guide('core-team-workflow'),
                new Guide('maintaining-plugins'),
                new Guide('maintaining-translations'),
                new Guide('apis'),
                new Guide('debugging-core'),
                new Guide('profiling-code'),
                new Guide('reproducing-issues'),
                new Guide('core-faqs'),
                new Guide('core-components'),
                new Guide('composer-dependencies'),
                new Guide('release-management'),
                new Guide('github-actions'),
                new RemoteLink('Matomo\'s Roadmap', 'https://matomo.org/roadmap/'),
            ]),
            new EmptySubCategory('Matomo Plugin development', [
                new Guide('tagmanager/in-depth'),
            ]),
            new UnlinkedCategory('in-depth-web-interface'),
            new UnlinkedCategory('in-depth-utils'),
            new UnlinkedCategory('in-depth-reporting-api'),
            new Guide('data-model'),
            new UnlinkedCategory('in-depth-tests'),
            new UnlinkedCategory('in-depth-tools'),
            new DevelopCategory(),
        ];
    }

    public function getUrl()
    {
        return '/piwik-in-depth';
    }

    public function getIntroGuide()
    {
        return new Guide('piwik-in-depth-introduction');
    }
}
