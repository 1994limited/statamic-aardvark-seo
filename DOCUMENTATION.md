# Aardvark SEO Documentation

## Installation

Install via composer:
```
composer require withcandour/aardvark-seo
```

...or alternatively search for us in the `Tools > Addons` section of the Statamic control panel.

### Tags

Getting your site's SEO data onto the page relies on a few tags being present in your theme templates:

- `{{ aardvark-seo:head }}` - Contains meta tags and other information, this tag should be inside of the `<head>` element (in place of any title or meta tags)
- `{{ aardvark-seo:body }}` - Contains scripts that need to be inside of the `<body>` element, it should be placed after the opening `<body>` tag.
- `{{ aardvark-seo:footer }}` - Contains any scripts that need to be included at the end of the page, it should be placed towards the end of page along with any other scripts you have in the footer.

## Permissions

Aardvark SEO now has a set of permissions which can be applied to user roles, head to the permissions section of the control panel to take a look, non-super users will now need permission to view and update the global settings. There are additional permissions for creating and updating redirects.

## Sitemaps

XML Sitemaps will get automatically generated for your site, the default url for the sitemap is `<your-site-address>/sitemap.xml`, however you are welcome to turn this off by heading to SEO > Sitemap and toggling "Enable Sitemap?" off.

The priority and change frequency can be configured on a per-page basis under the 'SEO' section.

Individual collections / taxonomies can be excluded from the sitemap with the settings under SEO > Sitemap.

## Redirects

You can manage the list of redirects for your site from within the control panel, the Redirects item in the Tools section of the control panel is the place to go for this.

## Marketing tools

Google tag manager can be enabled and managed through the Aardvark addon, additionally there is functionality to add verification codes for the major webmaster tools under the SEO > Marketing page.

## On-page SEO

A new 'SEO' section will be added to the editor screen for any Pages, Collection entries or Taxonomy terms from which the SEO and share data will be managed.

Special fields for the meta title and description will give you hints about the length of the content enabling you to optimize your metadata for search engines - a google search preview will help to visualise this.

### Disable
You can prevent the SEO tab from appearing by adding the handle of the collection/term to the `excluded_collections` or `excluded_taxonomies` array in the Aardvark config file.

## Indexing

Site indexing can be controlled either at the site-level (crawlers will not index any page) or on a per-page basis. On every page there is a toggle, when enabled the page will no longer get indexed. In addition there is a separate option for controlling whether on-page links should get followed by crawlers.

## Schema

A schema graph will be generated for each page which will pull data from the Aardvark global settings including things like the Organization and social media profiles linked to the website, additionally WebSite and WebPage schema will be generated automatically.

### Breadcrumbs

Another schema feature which will also be generated is the breadcrumb trail, Google provides [documentation](https://developers.google.com/search/docs/data-types/breadcrumb) about the specifics and how it is used. Aardvark automatically adds breadcrumbs for all pages on your site.

## Social media

Aardvark provides you with full control over how your site looks when shared on social media through generating data and filling opengraph and twitter meta tags. In addition you can set links to each of your social media profiles in the SEO > Social menu.

We have a list of default social types but you may define your own in the addon settings, use the grid to add items to the 'Social Icon' dropdown.

The social media data can be accessed on the frontend through the `{{ aardvark-seo:socials }}` tag, use it to loop through the provided social media links.

### Socials tag example

```html
<ul>
    {{ aardvark-seo:socials }}
        <li><a href="{{ url }}">{{ social_icon }}</a></li>
    {{ /aardvark-seo:socials }}
</ul>
```

## Multisite and Localization

Aardvark will provide full SEO functionality for Statamic instances running multisite as well as providing useful information for multisite instances running over multiple locales.

### Hreflang
Aardvark SEO will automatically generate a list of `<link rel="alternate" hreflang="x">` tags for Statamic instances running multiple sites where content is shared across locales. Additionally you can manually configure alternate urls using the 'Alternate URLs' table in the on-page SEO settings.

## Content defaults
You can set default SEO options on a per-content option. For example, SEO options can be set at the collection level, allowing for section-specific values for fields like the OpenGraph share image etc. To control the defaults head to SEO > Content Defaults in the menu and click through to each collection / taxonomy individually.
