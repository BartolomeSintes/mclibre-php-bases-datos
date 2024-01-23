import copy
import json

# La variable SELENIUM_FILE no se usa
SELENIUM_FILE = "biblioteca-4-pruebas.side.json"
SELENIUM_FILE = "biblioteca-4-2.side.json"
SELENIUM_FILE = "bases-de-datos-2-3.side"

lista = [
    # "bases-de-datos-1-b-0.side",
    # "bases-de-datos-1-b-1.side",
    # "bases-de-datos-1-b-2.side",
    # "bases-de-datos-2-b-0.side",
    # "bases-de-datos-2-b-1.side",
    # "bases-de-datos-2-b-2.side",
    "bases-de-datos-3-b-0.side",
    # "bases-de-datos-3-c-estadisticas-administrador.side",
    # "bases-de-datos-3-c-confirma-contrasena.side",
    # "bases-de-datos-3-c-usuario-miron.side",
    # "bases-de-datos-3-c-correo-usuarios.side",
    # "bases-de-datos-3-c-datos-repetidos.side",
    # "bases-de-datos-3-c-registros-incompletos.side",
    # "bases-de-datos-3-c-cambia-password.side",
    # "bases-de-datos-3-c-contador-conexiones.side",
    # "bases-de-datos-3-c-numero-registros-usuario.side",
]

def lee_json(fichero):
    # print("  Lee JSON")
    # print(f"    Leyendo JSON {fichero} ...")
    with open(fichero, encoding="utf-8") as file:
        return json.load(file)


def guarda_json(diccionario, fichero):
    # print("  Guarda JSON")
    # print(f"    Grabando JSON {fichero} ...")
    with open(fichero, "w", encoding="utf-8", newline='\n') as json_file:
        json.dump(
            diccionario, json_file, indent=4, ensure_ascii=False
        )  # ensure_ascii es para que no guarde los caracteres en la forma \u00f...


def renombra_tests(tmp):
    # selenium_json = lee_json(fichero)
    # print(selenium_json["tests"])
    selenium_json = copy.deepcopy(tmp)
    for i in range(len(selenium_json["tests"])):
        subpartes = 1
        for j in range(len(selenium_json["tests"][i]["commands"])):
            if "comment" in selenium_json["tests"][i]["commands"][j].keys() and selenium_json["tests"][i]["commands"][j]["comment"][:6] == "(TEST)":
                subpartes += 1
        nombre = selenium_json["tests"][i]["id"]
        contador_1 = 0
        contador_2 = 1
        for j in range(len(selenium_json["tests"][i]["commands"])):
            if "comment" in selenium_json["tests"][i]["commands"][j].keys() and selenium_json["tests"][i]["commands"][j]["comment"][:6] == "(TEST)":
                contador_1 += 1
                contador_2 = 1
            if subpartes > 1:
                selenium_json["tests"][i]["commands"][j]["id"] = f"{nombre}-{contador_1}-{contador_2}"
            else:
                selenium_json["tests"][i]["commands"][j]["id"] = f"{nombre}-{contador_2}"
            contador_2 += 1
    return selenium_json


def main():
    resp = -1
    while resp != 0:
        print("SELENIUM - UTILIDADES")
        print("1. Renombrar tests.")
        print("0. Salir.")
        try:
            resp = int(input("Elige una opción: "))
        except:
            resp = -1
        if resp == 1:
            print("  1. Renombrando tests ...")
            for fichero in lista:
                print(f"Analizando {fichero}")
                selenum_inicial = lee_json(fichero)
                selenium_final = renombra_tests(selenum_inicial)
                if selenium_final != selenum_inicial:
                    print(f"  Detectados cambios en {fichero}")
                    guarda_json(selenium_final, fichero)
        print()


if __name__ == "__main__":
    main()
