export default function ButtonDanger({ text, onClick }) {
    return (
        <button
            style={{
                padding: "10px 20px",
                backgroundColor: "#e74c3c",
                color: "white",
                border: "none",
                borderRadius: "5px",
                cursor: "pointer",
            }}
            onClick={onClick}
        >
            {text}
        </button>
    );
}
