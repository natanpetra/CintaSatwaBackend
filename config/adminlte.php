<?php
use Illuminate\Support\Str;

return [

  /*
  |--------------------------------------------------------------------------
  | Title
  |--------------------------------------------------------------------------
  |
  | The default title of your admin panel, this goes into the title tag
  | of your page. You can override it per page with the title section.
  | You can optionally also specify a title prefix and/or postfix.
  |
  */

  'title' => 'Clinic Management System',

  'title_prefix' => '',

  'title_postfix' => '',

  /*
  |--------------------------------------------------------------------------
  | Logo
  |--------------------------------------------------------------------------
  |
  | This logo is displayed at the upper left corner of your admin panel.
  | You can use basic HTML here if you want. The logo has also a mini
  | variant, used for the mini side bar. Make it 3 letters or so
  |
  */

  'logo' => '<img src="'. env('APP_URL').'img/primary-logo.png' .'" height="35" alt="mpp">',

  'logo_mini' => '<img src="'. env('APP_URL').'img/primary-icon.jpg' .'" height="35" alt="mpp">',

  /*
  |--------------------------------------------------------------------------
  | Skin Color
  |--------------------------------------------------------------------------
  |
  | Choose a skin color for your admin panel. The available skin colors:
  | blue, black, purple, yellow, red, and green. Each skin also has a
  | ligth variant: blue-light, purple-light, purple-light, etc.
  |
  */

  'skin' => 'red-light',

  /*
  |--------------------------------------------------------------------------
  | Layout
  |--------------------------------------------------------------------------
  |
  | Choose a layout for your admin panel. The available layout options:
  | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
  | removes the sidebar and places your menu in the top navbar
  |
  */

  'layout' => null,

  /*
  |--------------------------------------------------------------------------
  | Collapse Sidebar
  |--------------------------------------------------------------------------
  |
  | Here we choose and option to be able to start with a collapsed side
  | bar. To adjust your sidebar layout simply set this  either true
  | this is compatible with layouts except top-nav layout option
  |
  */

  'collapse_sidebar' => false,

  /*
  |--------------------------------------------------------------------------
  | URLs
  |--------------------------------------------------------------------------
  |
  | Register here your dashboard, logout, login and register URLs. The
  | logout URL automatically sends a POST request in Laravel 5.3 or higher.
  | You can set the request to a GET or POST with logout_method.
  | Set register_url to null if you don't want a register link.
  |
  */

  'dashboard_url' => '/',

  'logout_url' => 'logout',

  'logout_method' => null,

  'login_url' => 'login',

  'register_url' => 'register',

  /*
  |--------------------------------------------------------------------------
  | Menu Items
  |--------------------------------------------------------------------------
  |
  | Specify your menu items to display in the left sidebar. Each menu item
  | should have a text and and a URL. You can also specify an icon from
  | Font Awesome. A string instead of an array represents a header in sidebar
  | layout. The 'can' is a filter on Laravel's built in Gate functionality.
  |
  */

  'menu' => [
    'MASTER',
    // Dashboard/Menu Utama
    [
      'text' => 'Klinik',
      'url'  => 'master/clinic',
      'model'  => 'master/clinic',
      'can' => 'access-menu',
      'icon' => 'file-text-o',
    ],
    [
      'text' => 'Dokter',
      'url'  => 'master/doctor',
      'model'  => 'master/doctor',
      'can' => 'access-menu',
      'icon' => 'newspaper-o',
    ],
    [
      'text' => 'Dog Care Guide',
      'url'  => 'master/guide',
      'model'  => 'master/guide',
      'can' => 'access-menu',
      'icon' => 'question-circle',
    ],
    [
      'text' => 'Ectoparasite',
      'url'  => 'master/ectoparasite',
      'model'  => 'master/ectoparasite',
      'can' => 'access-menu',
      'icon' => 'question-circle',
    ],
    [
      'text' => 'Product',
      'url'  => 'master/product',
      'model'  => 'master/product',
      'can' => 'access-menu',
      'icon' => 'phone',
    ],
    // [
    //   'text' => 'Ras',
    //   'url'  => 'master/ras',
    //   'model'  => 'master/ras',
    //   'can' => 'access-menu',
    //   'icon' => 'dog',
    // ],
    [
      'text' => 'Ras Image',
      'url'  => 'master/ras-image',
      'model'  => 'master/ras-image',
      'can' => 'access-menu',
      'icon' => 'dog',
    ],
    'RIWAYAT',
    [
      'text' => 'Riwayat Reservasi',
      'url'  => 'history/history-reservation',
      'model'  => 'history/history-reservation',
      'can' => 'access-menu',
      'icon' => 'money',
    ],
    [
      'text' => 'Riwayat Pembelian',
      'url'  => 'history/history-purchase',
      'model'  => 'history/history-purchase',
      'can' => 'access-menu',
      'icon' => 'money',
    ],
    [
      'text' => 'Riwayat Pemeriksaan',
      'url'  => 'history/history-scan',
      'model'  => 'history/history-scan',
      'can' => 'access-menu',
      'icon' => 'money',
    ],
    'KARYAWAN',
    [
      'text'    => 'Pasien',
      'model'    => Str::slug('Employee', '_'),
      'can' => 'access-menu',
      'icon'    => 'address-card-o',
      'submenu' => [
        [
          'text' => 'Peran Pasien',
          'url'  => 'master/employee/role',
          'model'  => 'master/employee/role',
          'can' => 'access-menu',
          'icon' => 'key',
        ],
        [
          'text' => 'Pasien',
          'url'  => 'master/employee',
          'model'  => 'master/employee',
          'can' => 'access-menu',
          'icon' => 'user-o',
        ]
      ],
    ],
  ],

  /*
  |--------------------------------------------------------------------------
  | Menu Filters
  |--------------------------------------------------------------------------
  |
  | Choose what filters you want to include for rendering the menu.
  | You can add your own filters to this array after you've created them.
  | You can comment out the GateFilter if you don't want to use Laravel's
  | built in Gate functionality
  |
  */

  'filters' => [
    JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
    // JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
  ],

  /*
  |--------------------------------------------------------------------------
  | Plugins Initialization
  |--------------------------------------------------------------------------
  |
  | Choose which JavaScript plugins should be included. At this moment,
  | only DataTables is supported as a plugin. Set the value to true
  | to include the JavaScript file from a CDN via a script tag.
  |
  */

  'plugins' => [
    'datatables' => true,
    'select2'    => true,
    'chartjs'    => true,
  ],
];
