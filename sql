Pregunta 1
***********

SELECT
t1.Cliente, SUM(t1.Saldo)
FROM EX_CLIENTES_SALDOS as t1
WHERE
t1.Cliente IN ('A1', 'A2') AND
t1.saldo > 6000
GROUP BY t1.Cliente;

Pregunta 2
***********

SELECT
t1.*,
t2.*,
CASE t2.Nivel_de_riesgo
WHEN 'Alto' THEN t1.CEM_objetivo * 0.20
WHEN 'Medio' THEN t1.CEM_objetivo * 0.50
WHEN 'Bajo' THEN t1.CEM_objetivo * 0.70
ELSE NULL
END AS 'CEM Aprobado'
FROM EX_CLIENTES_SALDOS AS t1
INNER JOIN EX_NIVEL_RIESGO AS t2 ON t2.Rating = t1.Rating