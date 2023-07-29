<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MASTER MENU
    |--------------------------------------------------------------------------
    */

    'menu_super' => [
        [
            'id' => 'pengaturan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
            'title' => 'pengaturan',
            'url' => 'pengaturan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'pengguna',
                    'url' => 'pengguna',
                    'title' => 'pengguna'
                ]
            ]
        ],
        [
            'id' => 'data_master',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
            'title' => 'data master',
            'url' => 'data_master',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'barang',
                    'url' => 'barang',
                    'title' => 'barang'
                ],
                [
                    'id' => 'satuan',
                    'url' => 'satuan',
                    'title' => 'satuan'
                ],
                [
                    'id' => 'pelanggan',
                    'url' => 'pelanggan',
                    'title' => 'pelanggan'
                ],
                [
                    'id' => 'supplier',
                    'url' => 'supplier',
                    'title' => 'supplier'
                ]
            ]
        ],
        [
            'id' => 'barang_masuk',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>',
            'title' => 'barang_masuk',
            'url' => 'barang_masuk',
            'caret' => false,
        ],
        [
            'id' => 'penjualan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
            'title' => 'penjualan',
            'url' => 'penjualan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'barang_keluar',
                    'url' => 'barang_keluar',
                    'title' => 'kasir'
                ],
                [
                    'id' => 'data_penjualan',
                    'url' => 'data_penjualan',
                    'title' => 'data_penjualan'
                ],

            ]
        ],
        [
            'id' => 'laporan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
            'title' => 'laporan',
            'url' => 'laporan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'penjualan',
                    'url' => 'penjualan',
                    'title' => 'penjualan'
                ],
                [
                    'id' => 'kartu_stok',
                    'url' => 'kartu_stok',
                    'title' => 'kartu_stok'
                ],
                [
                    'id' => 'keuangan',
                    'url' => 'keuangan',
                    'title' => 'keuangan'
                ],

            ]
        ]


    ],
    'menu_admin' => [
        [
            'id' => 'data_master',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>',
            'title' => 'data master',
            'url' => 'data_master',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'barang',
                    'url' => 'barang',
                    'title' => 'barang'
                ],
                [
                    'id' => 'satuan',
                    'url' => 'satuan',
                    'title' => 'satuan'
                ],
                [
                    'id' => 'pelanggan',
                    'url' => 'pelanggan',
                    'title' => 'pelanggan'
                ],
                [
                    'id' => 'supplier',
                    'url' => 'supplier',
                    'title' => 'supplier'
                ]
            ]
        ],
        [
            'id' => 'barang_masuk',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>',
            'title' => 'barang_masuk',
            'url' => 'barang_masuk',
            'caret' => false,
        ],
        [
            'id' => 'penjualan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
            'title' => 'penjualan',
            'url' => 'penjualan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'barang_keluar',
                    'url' => 'barang_keluar',
                    'title' => 'kasir'
                ],
                [
                    'id' => 'data_penjualan',
                    'url' => 'data_penjualan',
                    'title' => 'data_penjualan'
                ],

            ]
        ],
        [
            'id' => 'laporan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
            'title' => 'laporan',
            'url' => 'laporan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'penjualan',
                    'url' => 'penjualan',
                    'title' => 'penjualan'
                ],
                [
                    'id' => 'kartu_stok',
                    'url' => 'kartu_stok',
                    'title' => 'kartu_stok'
                ],
                [
                    'id' => 'keuangan',
                    'url' => 'keuangan',
                    'title' => 'keuangan'
                ],

            ]
        ]
    ],
    'menu_kasir' => [
        [
            'id' => 'penjualan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
            'title' => 'penjualan',
            'url' => 'penjualan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'barang_keluar',
                    'url' => 'barang_keluar',
                    'title' => 'kasir'
                ],

            ]
        ],
        [
            'id' => 'laporan',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
            'title' => 'laporan',
            'url' => 'laporan',
            'caret' => true,
            'sub_menu' => [
                [
                    'id' => 'kartu_stok',
                    'url' => 'kartu_stok',
                    'title' => 'kartu_stok'
                ],
                [
                    'id' => 'keuangan',
                    'url' => 'keuangan',
                    'title' => 'keuangan'
                ],

            ]
        ]
    ]
];
