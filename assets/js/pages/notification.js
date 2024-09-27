function markAsRead(leaveId) {
    fetch('update_notification.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'lid=' + leaveId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // อัปเดต UI หรือทำการ redirect ไปยังหน้ารายละเอียดการลา
            window.location.href = 'leave-details.php?leaveid=' + leaveId;
        } else {
            console.error('Failed to update notification status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}