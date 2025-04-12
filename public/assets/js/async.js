import axios_ins from "/assets/js/axios.js";

document.querySelectorAll('.change-status').forEach(item => {
    item.onchange = async () => {
        const user_id = item.getAttribute('data-id');
        const is_active = item.checked; 

        try {
            const res = await axios_ins.put(`users/${user_id}`, { is_active });

            if (res.status === 200) {
                const statusEl = document.getElementById(`status-${user_id}`);

                statusEl.innerText = is_active ? 'Hoạt động' : 'Không hoạt động';

                statusEl.classList.remove('bg-label-success', 'bg-label-danger');

                statusEl.classList.add(is_active ? 'bg-label-success' : 'bg-label-danger');
            }
        } catch (err) {
            console.error('Cập nhật trạng thái thất bại:', err);
        }
    };
});
