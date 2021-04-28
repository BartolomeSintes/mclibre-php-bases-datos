import json

SELENIUM_FILE = "biblioteca-4-pruebas.side.json"
SELENIUM_FILE = "biblioteca-4-2.side.json"


def lee_json(fichero):
    # print("  Lee JSON")
    # print(f"    Leyendo JSON {fichero} ...")
    with open(fichero, encoding="utf-8") as file:
        return json.load(file)


def guarda_json(diccionario, fichero):
    # print("  Guarda JSON")
    # print(f"    Grabando JSON {fichero} ...")
    with open(fichero, "w", encoding="utf-8") as json_file:
        json.dump(
            diccionario, json_file, indent=4, ensure_ascii=False
        )  # ensure_ascii es para que no guarde los caracteres en la forma \u00f...


def renombra_tests(fichero):
    selenium_json = lee_json(fichero)
    # print(selenium_json["tests"])
    for i in range(len(selenium_json["tests"])):
        nombre = selenium_json["tests"][i]["id"]
        for j in range(len(selenium_json["tests"][i]["commands"])):
            selenium_json["tests"][i]["commands"][j]["id"] = f"{nombre}-{j+1}"
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
            selenium_side = renombra_tests(SELENIUM_FILE)
            guarda_json(selenium_side, SELENIUM_FILE)
        print()


if __name__ == "__main__":
    main()
