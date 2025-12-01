<?php

return [
    'title' => 'Registration Form - CICTED 2026',
    'header' => [
        'back_link' => '← Back to Homepage',
    ],
    'main_title' => 'CICTED-2026 Registration Form',
    'description' => 'Register for the congress that will take place on September 16th and 17th, 2026.',

    'labels' => [
        'full_name' => 'Full name(s) of the author(s)',
        'email' => 'E-mail',
        'academic_level' => 'Academic level',
        'occupation' => 'Occupation',
        'institution' => 'Institution and country of origin',
        'participant_type' => 'Participant type',
        'presentation_modality' => 'Presentation modality',
        'thematic_axis' => 'Thematic axis of your presentation',
        'abstract' => 'Abstract of your presentation (250 to 300 words)',
        'keywords' => 'Keywords (3 to 5 words)',
        'abstract_submission' => 'Submit the simple abstract in MS Word format',
    ],

    'options' => [
        'level' => [
            'phd' => 'PhD',
            'master' => 'Master\'s',
            'bachelor' => 'Bachelor\'s',
            'technician' => 'Technician/Associate',
        ],
        'occupation' => [
            'ug_student' => 'Undergraduate student',
            'pg_student' => 'Postgraduate student',
            'lecturer' => 'Lecturer',
            'researcher' => 'Researcher',
        ],
        'participant_type' => [
            'speaker' => 'Speaker',
            'attendee' => 'Attendee',
        ],
        'modality' => [
            'round_table' => 'Round table',
            'oral_communication' => 'Oral communication',
            'poster' => 'Poster',
        ],
    ],

    'file_upload' => [
        'cta' => 'Click to select a file',
        'info' => 'DOC, DOCX (Max 10MB)',
        'selected_prefix' => 'File selected:',
    ],
    
    'buttons' => [
        'submit' => 'Submit Registration',
    ],

    'required_field' => 'Required field',
];