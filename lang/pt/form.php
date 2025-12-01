<?php

return [
    'title' => 'Formulário de Inscrição - CICTED 2026',
    'header' => [
        'back_link' => '← Voltar à Página Principal',
    ],
    'main_title' => 'Formulário de Inscrição CICTED-2026',
    'description' => 'Faça a sua inscrição para o congresso que decorrerá nos dias 16 e 17 de Setembro de 2026.',

    'labels' => [
        'full_name' => 'Nome(s) completo(s) do(s) autor(es)',
        'email' => 'E-mail',
        'academic_level' => 'Nível académico',
        'occupation' => 'Ocupação',
        'institution' => 'Instituição e país de proveniência',
        'participant_type' => 'Tipo de participante',
        'presentation_modality' => 'Modalidade de apresentação',
        'thematic_axis' => 'Eixo temático da sua apresentação',
        'abstract' => 'Resumo da sua apresentação (250 a 300 palavras)',
        'keywords' => 'Palavras-chave (3 a 5 palavras)',
        'abstract_submission' => 'Submeta o resumo simples no formato MS Word',
    ],

    'options' => [
        'level' => [
            'phd' => 'Doutor',
            'master' => 'Mestre',
            'bachelor' => 'Licenciado',
            'technician' => 'Médio',
            'outher' => 'Outro',
        ],
        'occupation' => [
            'ug_student' => 'Estudante de graduação',
            'pg_student' => 'Estudante da pós-graduação',
            'lecturer' => 'Docente',
            'researcher' => 'Investigador',
             'outher' => 'Outro',
        ],
        'participant_type' => [
            'speaker' => 'Orador',
            'attendee' => 'Ouvinte',
        ],
        'modality' => [
            'round_table' => 'Mesa-redonda',
            'oral_communication' => 'Comunicação oral',
            'poster' => 'Poster',
        ],
    ],

    'file_upload' => [
        'cta' => 'Clique para selecionar um ficheiro',
        'info' => 'DOC, DOCX (Max 10MB)',
        'selected_prefix' => 'Ficheiro selecionado:',
    ],
    
    'buttons' => [
        'submit' => 'Submeter Inscrição',
    ],

    'required_field' => 'Campo obrigatório',
];