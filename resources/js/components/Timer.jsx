import { useState, useEffect } from "react";

export default function Timer() {
    const [timeLeft, setTimeLeft] = useState({
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0
    });

    useEffect(() => {
        const targetDate = new Date('2025-09-12T00:00:00');

        const interval = setInterval(() => {
            const now = new Date();
            const difference = targetDate - now;

            if (difference <= 0) {
                clearInterval(interval);
                setTimeLeft({ days: 0, hours: 0, minutes: 0, seconds: 0 });
                return;
            }

            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            setTimeLeft({ days, hours, minutes, seconds });
        }, 1000);

        return () => clearInterval(interval);
    }, []);

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
