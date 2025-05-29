document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('[data-collection-holder]');
    if (!container) return;

    const prototype = container.dataset.prototype;
    let index = container.querySelectorAll('.proposal-item').length;
    const addButton = container.querySelector('[data-add-proposal]');

    function createProposalItem(proposalHtmlRaw) {
        const temp = document.createElement('div');
        temp.innerHTML = proposalHtmlRaw;

        const input = temp.querySelector('input');
        if (!input) return null;

        const wrapper = document.createElement('div');
        wrapper.className = 'proposal-item mb-2 d-flex align-items-center gap-3';

        const inputContainer = document.createElement('div');
        inputContainer.className = 'flex-grow-1';
        inputContainer.appendChild(input);

        const removeBtn = document.createElement('button');
        removeBtn.setAttribute('type', 'button');
        removeBtn.className = 'btn btn-outline-danger btn-icon btn-sm remove-proposal';
        removeBtn.setAttribute('title', 'Supprimer');
        removeBtn.innerHTML = '<i class="bi bi-trash"></i>';

        removeBtn.addEventListener('click', () => wrapper.remove());

        wrapper.appendChild(inputContainer);
        wrapper.appendChild(removeBtn);

        return wrapper;
    }

    if (addButton) {
        addButton.addEventListener('click', () => {
            const newFormHtml = prototype.replace(/__name__/g, index);
            index++;

            const item = createProposalItem(newFormHtml);
            if (item) {
                container.insertBefore(item, addButton);
            }
        });
    }

    container.querySelectorAll('.remove-proposal').forEach(btn => {
        btn.addEventListener('click', e => {
            e.currentTarget.closest('.proposal-item').remove();
        });
    });

    const answerTypeField = document.querySelector('#question_answerType');
    const proposedBlock = document.querySelector('#proposed-block');

    if (answerTypeField && proposedBlock) {
        console.log('menu déroulant détecté');
        function toggleProposalFields() {
            console.log('type sélectionné :', answerTypeField.value);
            const type = answerTypeField.value;
            if (type === 'proposed') {
                proposedBlock.style.display = 'block';
            } else {
                proposedBlock.style.display = 'none';
            }
        }   

        toggleProposalFields();
    
        answerTypeField.addEventListener('change', () => {
            console.log('changement détecté');
            toggleProposalFields();
        });
    }
});
