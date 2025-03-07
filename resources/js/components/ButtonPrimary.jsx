export default function ButtonPrimary({ text, onClick }) {
    return (
        <button
            style={{
                padding: "10px 20px",
                backgroundColor: "#3498db",
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
