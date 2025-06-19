document.querySelectorAll('.nonder').forEach(jonkers => {
    jonkers.addEventListener('click', () => {
        const drager = jonkers.closest('.zikker');
        const zager = drager.querySelector('.zolder');
        
        document.querySelectorAll('.zolder').forEach(f => f.style.display = 'none');
        document.querySelectorAll('.nonder').forEach(btn => btn.style.display = 'inline-block');

        zager.style.display = 'block';
        jonkers.style.display = 'none';
    });
});

document.querySelectorAll('.bonder').forEach(jonkers => {
    jonkers.addEventListener('click', () => {
        const drager = jonkers.closest('.zikker');
        const zager = drager.querySelector('.zolder');
        const changeButton = drager.querySelector('.nonder');

        zager.style.display = 'none';
        changeButton.style.display = 'inline-block';
    });
});
