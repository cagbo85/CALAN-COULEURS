import React, { useState } from 'react';
import { ChevronDown, ChevronUp } from 'lucide-react';

export default function FAQItem({ question, answer }) {
  const [open, setOpen] = useState(false);

  return (
    <div className="bg-white/10 backdrop-blur-md rounded-md text-white px-4 py-3 transition-all duration-300 cursor-pointer" onClick={() => setOpen(!open)}>
      <button
        className="w-full flex justify-between items-center font-semibold uppercase text-left"
      >
        {question}
        {open ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
      </button>
      {open && (
        <p className="mt-2 text-sm text-white/80">
          {answer}
        </p>
      )}
    </div>
  );
}
