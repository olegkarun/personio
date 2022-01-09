# TYPO3 Extension `personio`

[![TYPO3 10](https://img.shields.io/badge/TYPO3-10-orange.svg)](https://get.typo3.org/version/10)
[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-orange.svg)](https://get.typo3.org/version/11)

## 1 Features

* Job positions from Personio XML feed

## 2 Usage

### 2.1 Installation

#### Installation using Composer

The recommended way to install the extension is using [Composer][1].

Run the following command within your Composer based TYPO3 project:

```
composer require pkd/personio
```

#### Installation as extension from TYPO3 Extension Repository (TER)

Download and install the [extension][2] with the extension manager module.

### 2.2 Pre-requisite settings on Personio
1. [Enable the XML-Feed][3] on your career page. After activation the feed is available at the following URL i.e. https://youraccount.jobs.personio.de/xml

### 2.3 Minimal setup
1) Include the static TypoScript of the extension. 
2) Create a list plugin on a page
3) Create a show plugin on a page

**Filtering**
For filtering, the specification of the feed URL in the plugin is required. Please specify a feed URL and save the plugin first. After saving, the filters are obtained from the personio xml feed.

**Route Enhancers**
```
routeEnhancers:
  Personio:
    limitToPages:
      - 26
    type: Extbase
    extension: Personio
    plugin: Show
    routes:
      -
        routePath: '/{uid}'
        _controller: 'Personio::show'
    defaultController: 'Personio::show'
```
*26=Uid of your page with a show plugin

[1]: https://getcomposer.org/
[2]: https://extensions.typo3.org/extension/personio
[3]: https://support.personio.de/hc/en-us/articles/207576365-Integrating-Positions-From-Personio-Into-Your-Company-Website-via-XML#publishing-positions-via-xml
