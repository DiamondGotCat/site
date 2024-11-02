let audioContext;
let lastTime = {
    seconds: new Date().getSeconds(),
    minutes: new Date().getMinutes(),
    hours: new Date().getHours()
};

function initializeAudioContext() {
    if (!audioContext) {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
    }
}

function playSound(frequency, duration, times = 1, interval = 200) {
    if (!audioContext) return;

    for (let i = 0; i < times; i++) {
        setTimeout(() => {
            const oscillator = audioContext.createOscillator();
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(frequency, audioContext.currentTime);

            const gainNode = audioContext.createGain();
            gainNode.gain.setValueAtTime(0.5, audioContext.currentTime);

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.start();
            oscillator.stop(audioContext.currentTime + duration / 1000);
        }, i * interval);
    }
}

function checkAndPlaySounds(currentTime) {
    const secondDiff = currentTime.seconds - lastTime.seconds;
    const minuteDiff = currentTime.minutes - lastTime.minutes;
    const hourDiff = currentTime.hours - lastTime.hours;

    // 時間の変更をチェック
    if (hourDiff !== 0) {
        playSound(1000, 1000); // ピー
    } 
    // 分の変更をチェック（優先度：分が5変わった時 > 分が1変わった時）
    else if (minuteDiff >= 5 || minuteDiff <= -5) {
        playSound(1000, 500, 3); // ピッピッピッ
    } else if (minuteDiff !== 0) {
        playSound(1000, 500, 2); // ピッピッ
    } 
    // 秒の変更をチェック（優先度：秒が5変わった時 > 秒が1変わった時）
    else if (secondDiff >= 5 || secondDiff <= -5) {
        playSound(2000, 200, 5, 200); // ピピピピッ
    } else if (secondDiff !== 0) {
        playSound(2000, 200); // ピッ
    }

    lastTime = currentTime;
}

function updateTime() {
    const hoursOffset = parseInt(document.getElementById('hoursOffset').value, 10);
    const offsetSign = document.getElementById('offsetSign').value;

    const currentDate = new Date();
    const localTime = currentDate.toLocaleTimeString('ja-JP');

    let specifiedDate = new Date(currentDate);
    if (offsetSign === '+') {
        specifiedDate.setHours(currentDate.getHours() + hoursOffset);
    } else {
        specifiedDate.setHours(currentDate.getHours() - hoursOffset);
    }

    const specifiedTime = specifiedDate.toLocaleTimeString('ja-JP');

    document.getElementById('currentLocalTime').innerText = localTime;
    document.getElementById('specifiedTime').innerText = specifiedTime;

    const currentTime = {
        seconds: currentDate.getSeconds(),
        minutes: currentDate.getMinutes(),
        hours: currentDate.getHours()
    };
    
    checkAndPlaySounds(currentTime);
}

document.addEventListener('click', initializeAudioContext);
document.getElementById('hoursOffset').addEventListener('input', updateTime);
document.getElementById('offsetSign').addEventListener('change', updateTime);

setInterval(updateTime, 1);
updateTime();