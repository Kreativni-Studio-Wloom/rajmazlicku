# Oprava pro mobilní zařízení - Smečka sekce

## Problém
Na mobilních zařízeních se neukazují čísla v sekci "Smečka" (7500+ druhů produktů, 3+ pobočky, atd.).

## Řešení implementované

### 1. Upravené parametry IntersectionObserver
- **Před:** `threshold: 0.3` (30% sekce musí být viditelné)
- **Po:** `threshold: 0.1` (10% sekce stačí pro spuštění)

### 2. Upravené rootMargin
- **Před:** `rootMargin: "0px 0px 0px 0px"`
- **Po:** `rootMargin: "0px 0px -50px 0px"` (spustí se dříve)

## Jak to funguje

1. **IntersectionObserver** sleduje viditelnost sekce "Smečka"
2. **Threshold 0.1** znamená, že animace se spustí, když je viditelných jen 10% sekce
3. **RootMargin -50px** znamená, že se spustí 50px před tím, než sekce vstoupí do viewportu
4. **Fallback timeout** spustí animaci po 3 sekundách, pokud IntersectionObserver nefunguje

## Testování

### Na PC:
- Čísla se animují při scrollování k sekci "Smečka"

### Na mobilu:
- Čísla by se měla animovat dříve a spolehlivěji
- Fallback timeout zajistí, že se animace spustí i při problémech s IntersectionObserver

## Poznámky

- **IntersectionObserver** může mít problémy na starších mobilních prohlížečích
- **Threshold 0.1** je kompromis mezi spolehlivostí a výkonem
- **RootMargin -50px** zajišťuje, že se animace spustí dříve
- **Fallback timeout** je záložní řešení pro všechny případy

## Pokud problém přetrvává

1. Zkontrolujte konzoli prohlížeče pro chybové zprávy
2. Otestujte na různých mobilních zařízeních
3. Zvažte snížení threshold na 0.05 nebo 0
4. Přidejte více fallback řešení
