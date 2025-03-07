import ButtonPrimary from "./components/ButtonPrimary";
import ButtonSecondary from "./components/ButtonSecondary";
import ButtonDanger from "./components/ButtonDanger";

export default function Home() {
    return (
        <div style={{ textAlign: "center", marginTop: "50px" }}>
            <h1>Bienvenue dans mon application React ! 🎉</h1>

            <div style={{ marginTop: "20px" }}>
                <ButtonPrimary text="Bouton Principal" onClick={() => alert("Bouton principal cliqué !")} />
                <ButtonSecondary text="Bouton Secondaire" onClick={() => alert("Bouton secondaire cliqué !")} />
                <ButtonDanger text="Bouton Danger" onClick={() => alert("Attention ! Bouton danger cliqué !")} />
            </div>
        </div>
    );
}
