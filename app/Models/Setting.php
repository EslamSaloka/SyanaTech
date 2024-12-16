<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model {

    use Translatable, HasFactory;

    protected $with =[
        'translations'
    ];


    protected $translationForeignKey = "setting_id";

    public $translatedAttributes = ['value'];

    protected $table = "settings";

    protected $fillable = ['key', 'group_by'];

    public $translationModel = 'App\Models\Translation\SettingTranslation';

    const FORM_INPUTS = [
        'standard' => [
            'title' => 'Standard Setting',
            'short_desc' => '...',
            'icon' => 'bxs-widget',
            'form' => [
                'lang' => [
                    'inputs' => [
                        [
                            'label'         => 'App Name',
                            'name'          => 'app_name',
                            'placeholder'   => 'Enter Application Name',
                            'type'          => 'text',
                        ],
                    ]
                ],
                'inputs' => [
                    [
                        'label'         => 'Phone',
                        'name'          => 'phone',
                        'type'          => 'text',
                        'placeholder'   => 'Enter Phone Number',
                    ],
                    [
                        'label'         => 'WhatsApp',
                        'name'          => 'whatsapp',
                        'type'          => 'text',
                        'placeholder'   => 'Enter WhatsApp Number',
                    ],
                    [
                        'label'         => 'Email',
                        'name'          => 'email',
                        'type'          => 'email',
                        'placeholder'   => 'Enter Email Address',
                    ],
                ],
            ],
        ],
        'social' => [
            'title' => 'Social',
            'short_desc' => '...',
            'icon' => 'bxs-show',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'Facebook',
                        'name'          => 'facebook',
                        'type'          => 'url',
                        'placeholder'   => 'Enter Facebook Link',
                    ],
                    [
                        'label'         => 'Twitter',
                        'name'          => 'twitter',
                        'type'          => 'url',
                        'placeholder'   => 'Enter Twitter Link',
                    ],
                    [
                        'label'         => 'Instagram',
                        'name'          => 'instagram',
                        'type'          => 'url',
                        'placeholder'   => 'Enter Instagram Link',
                    ],
                ]
            ],
        ],
        // 'vat' => [
        //     'title' => 'VAT',
        //     'short_desc' => '...',
        //     'icon' => 'bxs-show',
        //     'form' => [
        //         'inputs' => [
        //             [
        //                 'label'         => 'VAT ( 0% )',
        //                 'name'          => 'vat',
        //                 'type'          => 'number',
        //                 'placeholder'   => 'Enter Vat 0%',
        //                 'attr'          => [
        //                     "min"  => 1
        //                 ],
        //             ],
        //         ]
        //     ],
        // ],
        // 'dues' => [
        //     'title' => 'Dues',
        //     'short_desc' => '...',
        //     'icon' => 'bxs-show',
        //     'form' => [
        //         'inputs' => [
        //             [
        //                 'label'         => 'Dues ( 0% )',
        //                 'name'          => 'dues',
        //                 'type'          => 'number',
        //                 'placeholder'   => 'Enter Dues 0%',
        //             ],
        //         ]
        //     ],
        // ],
        // 'fire_base' => [
        //     'title' => 'Fire Base Key Intgration',
        //     'short_desc' => '...',
        //     'icon' => 'bxs-show',
        //     'form' => [
        //         'inputs' => [
        //             [
        //                 'label'         => 'Fire Base Key',
        //                 'name'          => 'fire_base_server_key',
        //                 'type'          => 'text',
        //                 'placeholder'   => 'Fire Base Key',
        //             ],
        //         ]
        //     ],
        // ],
    ];

}

