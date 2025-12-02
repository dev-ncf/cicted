
        document.addEventListener('DOMContentLoaded', function() {
            const tipoParticipanteRadios = document.querySelectorAll('input[name="tipo_participante"]');
            const camposOrador = document.getElementById('campos-orador');
            function checkSpeakerFields() {
                const selected = document.querySelector('input[name="tipo_participante"]:checked');
                if (selected && selected.value === 'orador') {
                    camposOrador.classList.remove('hidden');
                } else {
                    camposOrador.classList.add('hidden');
                }
            }
            
            checkSpeakerFields();

            tipoParticipanteRadios.forEach(radio => {
                radio.addEventListener('change', checkSpeakerFields);
            });

            const fileInput = document.getElementById('resumo_file');
            const filenameDisplay = document.getElementById('filename');
            const fileSelectedPrefix = "{{ __('form.file_upload.selected_prefix') ?? 'Arquivo selecionado:' }}";
            
            if(fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        filenameDisplay.textContent = fileSelectedPrefix + ' ' + this.files[0].name;
                        filenameDisplay.classList.add('p-2', 'bg-blue-100', 'rounded', 'inline-block');
                    } else {
                        filenameDisplay.textContent = '';
                        filenameDisplay.classList.remove('p-2', 'bg-blue-100', 'rounded', 'inline-block');
                    }
                });
            }
        });
  