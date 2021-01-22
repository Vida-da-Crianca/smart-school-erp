<?php


return $config = [
    'document/create' => [
        [
            'field' => 'title',
            'label' => 'Titulo do documento',
            'rules' => 'trim|required|xss_clean',
            'errors' => [
                'required' => 'Atenção o <b>%s</b> é necessário.',
            ],
        ],
        [
            'field' => 'body',
            'label' => 'Descrição do documento',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Atenção a <b>%s</b> é necessário.',
            ],
        ]
    ]
];
