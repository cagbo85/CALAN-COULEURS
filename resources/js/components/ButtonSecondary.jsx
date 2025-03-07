export default function ButtonSecondary({ text, onClick }) {
    return (
        <button
            style={{
                padding: "10px 20px",
                backgroundColor: "#2ecc71",
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
