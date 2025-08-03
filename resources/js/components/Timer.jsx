import { useState, useEffect } from "react";

export default function Timer() {
    const [timeLeft, setTimeLeft] = useState({
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0
    });
    const [isEventStarted, setIsEventStarted] = useState(false);
    const [isEventEnded, setIsEventEnded] = useState(false);

    useEffect(() => {
        // Festival commence vendredi 12 septembre à 20h
        const eventStartDate = new Date('2025-09-12T20:00:00');
        // Festival se termine dimanche 14 septembre à 6h (samedi soir/dimanche matin)
        const eventEndDate = new Date('2025-09-14T06:00:00');

        const interval = setInterval(() => {
            const now = new Date();
            const differenceToStart = eventStartDate - now;
            const differenceToEnd = eventEndDate - now;

            // Le festival est terminé
            if (differenceToEnd <= 0) {
                clearInterval(interval);
                setIsEventEnded(true);
                setTimeLeft({ days: 0, hours: 0, minutes: 0, seconds: 0 });
                return;
            }

            // Le festival a commencé mais n'est pas terminé
            if (differenceToStart <= 0 && differenceToEnd > 0) {
                setIsEventStarted(true);
                setTimeLeft({ days: 0, hours: 0, minutes: 0, seconds: 0 });
                return;
            }

            // Compte à rebours avant le début du festival
            const days = Math.floor(differenceToStart / (1000 * 60 * 60 * 24));
            const hours = Math.floor((differenceToStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((differenceToStart % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((differenceToStart % (1000 * 60)) / 1000);

            setTimeLeft({ days, hours, minutes, seconds });
        }, 1000);

        return () => clearInterval(interval);
    }, []);

    // Affichage quand le festival est terminé
    if (isEventEnded) {
    return (
        <div className="rounded-xl p-6">
            <div className="backdrop-blur-md shadow-lg px-4 sm:px-8 py-6 sm:py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white"
                style={{background: "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))"}}>
                <div className="text-4xl sm:text-6xl mb-4 drop-shadow-lg">🎉</div>
                <h3 className="text-2xl sm:text-3xl font-bold mb-2 tracking-wider drop-shadow-md text-center">Merci à tous !</h3>
                <p className="text-lg sm:text-xl text-center drop-shadow-md font-semibold">Le festival Calan'Couleurs 2025 est terminé</p>
                <p className="text-sm sm:text-base text-center mt-2 drop-shadow-md">À l'année prochaine pour de nouveaux moments magiques !</p>
            </div>
        </div>
    );
}

    // Affichage quand le festival a commencé
    if (isEventStarted) {
    return (
        <div className="rounded-xl p-6">
            <div className="backdrop-blur-md shadow-lg px-4 sm:px-8 py-6 sm:py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white animate-pulse"
                style={{background: "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))"}}>
                <div className="text-4xl sm:text-6xl mb-4 drop-shadow-lg">🎵</div>
                <h3 className="text-2xl sm:text-3xl font-bold mb-2 tracking-wider drop-shadow-md text-center">C'est parti !</h3>
                <p className="text-lg sm:text-xl text-center drop-shadow-md font-semibold">Le festival Calan'Couleurs 2025 a commencé</p>
                <p className="text-sm sm:text-base text-center mt-2 drop-shadow-md">Profitez bien de ces moments magiques !</p>
                <div className="mt-4 flex gap-2">
                    <span className="animate-bounce drop-shadow-lg">🎶</span>
                    <span className="animate-bounce delay-100 drop-shadow-lg">🎸</span>
                    <span className="animate-bounce delay-200 drop-shadow-lg">🎤</span>
                </div>
            </div>
        </div>
    );
    }

    // Compte à rebours normal
    return (
        <div className="rounded-xl p-6">
            <div className="flex flex-wrap justify-center gap-2 sm:gap-4">
                <div className="flex flex-col items-center justify-center bg-white/70 backdrop-blur-sm text-[#FF0F63] font-bold px-3 sm:px-4 py-2 rounded-lg shadow-md border-2 border-[#8F1E98]/20">
                    <span className="text-3xl sm:text-4xl md:text-5xl">{String(timeLeft.days).padStart(2, '0')}</span>
                    <span className="text-xs sm:text-sm uppercase tracking-wider mt-1">Jours</span>
                </div>
                <div className="flex flex-col items-center justify-center bg-white/70 backdrop-blur-sm text-[#FF0F63] font-bold px-3 sm:px-4 py-2 rounded-lg shadow-md border-2 border-[#8F1E98]/20">
                    <span className="text-3xl sm:text-4xl md:text-5xl">{String(timeLeft.hours).padStart(2, '0')}</span>
                    <span className="text-xs sm:text-sm uppercase tracking-wider mt-1">Heures</span>
                </div>
                <div className="flex flex-col items-center justify-center bg-white/70 backdrop-blur-sm text-[#FF0F63] font-bold px-3 sm:px-4 py-2 rounded-lg shadow-md border-2 border-[#8F1E98]/20">
                    <span className="text-3xl sm:text-4xl md:text-5xl">{String(timeLeft.minutes).padStart(2, '0')}</span>
                    <span className="text-xs sm:text-sm uppercase tracking-wider mt-1">Min</span>
                </div>
                <div className="flex flex-col items-center justify-center bg-white/70 backdrop-blur-sm text-[#FF0F63] font-bold px-3 sm:px-4 py-2 rounded-lg shadow-md border-2 border-[#8F1E98]/20">
                    <span className="text-3xl sm:text-4xl md:text-5xl">{String(timeLeft.seconds).padStart(2, '0')}</span>
                    <span className="text-xs sm:text-sm uppercase tracking-wider mt-1">Sec</span>
                </div>
            </div>
        </div>
    );
}
