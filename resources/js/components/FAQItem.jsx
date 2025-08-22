import React, { useState } from "react";
import { ChevronDown, ChevronUp } from "lucide-react";

export default function FAQItem({
    idBase,
    buttonId,
    panelId,
    question,
    answer,
}) {
    const [open, setOpen] = useState(false);
    const toggle = () => setOpen((o) => !o);

    return (
        <div
            className="bg-white/10 backdrop-blur-md rounded-md text-white px-4 py-3"
            data-open={open ? "true" : "false"}
        >
            {/* Utilise un vrai <button> pour le clavier + SR */}
            <h3 className="m-0">
                <button
                    id={buttonId}
                    type="button"
                    onClick={toggle}
                    aria-expanded={open}
                    aria-controls={panelId}
                    className="w-full flex justify-between items-center font-semibold uppercase text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#8F1E98] rounded-md py-1"
                >
                    <span>{question}</span>
                    <span aria-hidden="true" className="ml-2">
                        {open ? (
                            <ChevronUp
                                size={18}
                                aria-hidden="true"
                                focusable="false"
                            />
                        ) : (
                            <ChevronDown
                                size={18}
                                aria-hidden="true"
                                focusable="false"
                            />
                        )}
                    </span>
                </button>
            </h3>

            {/* Panneau associé, annoncé correctement aux lecteurs d’écran */}
            <div
                id={panelId}
                role="region"
                aria-labelledby={buttonId}
                hidden={!open}
                className="mt-2 text-sm text-white/80"
            >
                <p>{answer}</p>
            </div>
        </div>
    );
}
