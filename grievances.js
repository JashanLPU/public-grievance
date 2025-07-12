document.addEventListener('DOMContentLoaded', () => {
    const grievanceForm = document.getElementById('grievance-form');
    const grievanceListDiv = document.getElementById('grievance-list');

    // Fetch and display grievances
    async function renderGrievances() {
        try {
            const response = await fetch('get_grievances.php');
            const grievances = await response.json();

            grievanceListDiv.innerHTML = '';

            if (grievances.length === 0) {
                grievanceListDiv.innerHTML = '<p class="empty-state">No active grievances. Be the first to report one!</p>';
            } else {
                grievances.forEach(g => {
                    const card = createGrievanceCard(g);
                    grievanceListDiv.appendChild(card);
                });
            }
        } catch (err) {
            console.error('Error fetching grievances:', err);
            grievanceListDiv.innerHTML = '<p class="empty-state">Could not load grievances.</p>';
        }
    }

    // Create grievance card
    function createGrievanceCard(g) {
        const card = document.createElement('div');
        const severityMap = { 4: 'critical', 3: 'high', 2: 'medium', 1: 'low' };
        card.className = `grievance-card severity-${severityMap[g.severity]}`;
        card.dataset.id = g.id;

        card.innerHTML = `
            <div class="card-header">
                <h4>${escapeHTML(g.title)}</h4>
                <span class="card-location"><i class="fa-solid fa-location-dot"></i> ${escapeHTML(g.location)}</span>
            </div>
            <p class="card-description">${escapeHTML(g.description)}</p>
            <div class="card-footer">
                <div class="upvote-section">
                    <button class="upvote-btn"><i class="fa-solid fa-arrow-up"></i></button>
                    <span class="upvote-count">${g.upvotes}</span>
                </div>
                <button class="resolve-btn">Mark as Resolved</button>
            </div>
        `;
        return card;
    }

    // Escape HTML to prevent XSS
    function escapeHTML(str) {
        return str?.replace(/[&<>'"]/g, tag => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
        }[tag] || tag)) || '';
    }

    // Handle grievance form submission
    grievanceForm.addEventListener('submit', async e => {
        e.preventDefault();

        const formData = new FormData(grievanceForm);
        const submitBtn = grievanceForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        try {
            const response = await fetch('add_grievance.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                grievanceForm.reset();
                renderGrievances();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (err) {
            console.error('Form submission error:', err);
            alert('A network error occurred. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Grievance';
        }
    });

    // Handle upvotes and resolving
    grievanceListDiv.addEventListener('click', async e => {
        const card = e.target.closest('.grievance-card');
        if (!card) return;

        const id = card.dataset.id;
        const isUpvote = e.target.closest('.upvote-btn');
        const isResolve = e.target.closest('.resolve-btn');
        const action = isUpvote ? 'upvote' : isResolve ? 'resolve' : null;

        if (!action) return;

        const formData = new FormData();
        formData.append('id', id);
        formData.append('action', action);

        try {
            const response = await fetch('update_grievance.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                renderGrievances();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (err) {
            console.error('Update error:', err);
            alert('A network error occurred.');
        }
    });

    // Initial render + refresh every 5s
    renderGrievances();
    setInterval(renderGrievances, 5000);
});
