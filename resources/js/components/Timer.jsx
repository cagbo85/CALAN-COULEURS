import { useState, useEffect } from "react";

export default function Timer() {
    const [edition, setEdition] = useState(null);
    const [timeLeft, setTimeLeft] = useState({ days: 0, hours: 0, minutes: 0, seconds: 0 });
    const [isEventStarted, setIsEventStarted] = useState(false);
    const [isEventEnded, setIsEventEnded] = useState(false);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch("/api/active/editions")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Erreur lors du chargement de l'édition active");
                }
                return response.json();
            })
            .then((data) => {
                if (data.length > 0) {
                    setEdition(data[0]); // ⚠️ Ton endpoint renvoie un tableau
                } else {
                    setError("Aucune édition active trouvée.");
                }
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    useEffect(() => {
        if (!edition) return;

        const start = new Date(edition.begin_date);
        const end = new Date(edition.ending_date);

        const interval = setInterval(() => {
            const now = new Date();

            if (now >= end) {
                setIsEventEnded(true);
                setIsEventStarted(false);
                clearInterval(interval);
                return;
            }

            if (now >= start && now < end) {
                setIsEventStarted(true);
                setIsEventEnded(false);
                return;
            }

            const diff = start - now;
            setTimeLeft({
                days: Math.floor(diff / (1000 * 60 * 60 * 24)),
                hours: Math.floor((diff / (1000 * 60 * 60)) % 24),
                minutes: Math.floor((diff / (1000 * 60)) % 60),
                seconds: Math.floor((diff / 1000) % 60),
            });
        }, 1000);

        return () => clearInterval(interval);
    }, [edition]);

    if (loading) {
        return (
            <div className="rounded-xl p-6">
                <div
                    className="backdrop-blur-md shadow-lg px-6 py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white"
                    style={{
                        background:
                            "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))",
                    }}
                >
                    <div className="text-5xl mb-4 drop-shadow-lg">⏳</div>
                    <h3 className="text-3xl font-bold mb-2 text-center drop-shadow-md">
                        Chargement...
                    </h3>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="rounded-xl p-6">
                <div
                    className="backdrop-blur-md shadow-lg px-6 py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white"
                    style={{
                        background:
                            "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))",
                    }}
                >
                    <BiSolidError className="text-5xl mb-4 text-red-400" />
                    <h3 className="text-2xl font-bold mb-2 text-center drop-shadow-md">
                        Erreur
                    </h3>
                    <p className="text-sm text-center opacity-90">{error}</p>
                </div>
            </div>
        );
    }

    // Affichage quand le festival est terminé
    if (isEventEnded) {
        return (
            <div className="rounded-xl p-6">
                <div
                    className="backdrop-blur-md shadow-lg px-6 py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white"
                    style={{
                        background:
                        "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))",
                    }}
                >
                    <div className="text-6xl mb-4 drop-shadow-lg">🎉</div>
                    <h3 className="text-3xl font-bold mb-2 text-center drop-shadow-md">
                        Merci à tous !
                    </h3>
                    <p className="text-lg font-semibold text-center">
                        La première édition {edition.name} est terminée.
                    </p>
                    <p className="text-sm text-center mt-2">À l'année prochaine 🎶</p>
                </div>
            </div>
        );
    }

    // Affichage quand le festival est en cours
    if (isEventStarted) {
        return (
            <div className="rounded-xl p-6">
                <div
                    className="backdrop-blur-md shadow-lg px-6 py-8 rounded-xl border border-white/50 flex flex-col items-center justify-center text-white animate-pulse"
                    style={{
                        background:
                            "linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3))",
                    }}
                >
                    <div className="text-6xl mb-4 drop-shadow-lg">🎵</div>
                    <h3 className="text-3xl font-bold mb-2 text-center drop-shadow-md">
                        C’est parti !
                    </h3>
                    <p className="text-lg font-semibold text-center">
                        Le festival {edition.name} a commencé 🎤
                    </p>
                    <p className="text-sm text-center mt-2">Profitez bien !</p>
                </div>
            </div>
        );
    }

    // Compte à rebours
    return (
        <div className="rounded-xl p-6">
            <div className="text-center mb-6">
                <h3 className="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">
                    Le festival {edition.name} commence dans :
                </h3>
            </div>

            <div className="flex flex-wrap justify-center gap-4">
                {["Jours", "Heures", "Min", "Sec"].map((label, i) => {
                    const value = [
                        timeLeft.days,
                        timeLeft.hours,
                        timeLeft.minutes,
                        timeLeft.seconds,
                    ][i];
                    return (
                        <div
                            key={label}
                            className="flex flex-col items-center bg-white/70 backdrop-blur-sm text-[#FF0F63] font-bold px-4 py-3 rounded-lg shadow-md border-2 border-[#8F1E98]/20"
                        >
                            <span className="text-4xl sm:text-5xl">
                                {String(value).padStart(2, "0")}
                            </span>
                            <span className="text-xs sm:text-sm uppercase mt-1 tracking-wider">
                                {label}
                            </span>
                        </div>
                    );
                })}
            </div>
        </div>
    );
}
