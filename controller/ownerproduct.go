package controller

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"html/template"
	"net/http"
	"strings"
	"time"
)

type ProductSales struct {
	NamaProduk   string `json:"nama_produk"`
	TotalTerjual int    `json:"total_terjual"`
}

type ProductDetail struct {
	NamaProduk string
	Kategori   string
	Harga      float64
	Stok       int
	Gambar     string
	Satuan     string
}

func OwnerProductHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		funcMap := template.FuncMap{
			"toJson": func(v interface{}) template.JS {
				b, _ := json.Marshal(v)
				return template.JS(b)
			},
		}

		tmpl := template.Must(template.New("ownerproduct.html").Funcs(funcMap).ParseFiles(
			"views/owner/ownerproduct.html",
			"parts/owner/navbar.html",
			"parts/owner/sidebar.html",
		))

		month := r.URL.Query().Get("month")
		if month == "" {
			month = fmt.Sprintf("%02d", time.Now().Month())
		}

		// Map bulan
		months := map[string]string{
			"01": "January", "02": "February", "03": "March", "04": "April",
			"05": "May", "06": "June", "07": "July", "08": "August",
			"09": "September", "10": "October", "11": "November", "12": "December",
		}

		// Ambil 8 produk terlaris
		rows, err := db.Query(`
			SELECT p.nama_produk, SUM(ps.jumlah) as total_terjual
			FROM pesanan ps
			JOIN produk p ON ps.id_produk = p.ID_Produk
			JOIN pembayaran pm ON ps.id_pembayaran = pm.id
			WHERE MONTH(pm.tanggal) = ?
			GROUP BY p.nama_produk
			ORDER BY total_terjual DESC
			LIMIT 8
		`, month)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var sales []ProductSales
		var topProducts []string
		for rows.Next() {
			var ps ProductSales
			if err := rows.Scan(&ps.NamaProduk, &ps.TotalTerjual); err == nil {
				sales = append(sales, ps)
				if len(topProducts) < 2 {
					topProducts = append(topProducts, ps.NamaProduk)
				}
			}
		}

		// Ambil detail 2 produk terlaris
		var products []ProductDetail
		if len(topProducts) > 0 {
			placeholders := strings.Repeat("?,", len(topProducts))
			placeholders = strings.TrimSuffix(placeholders, ",")

			query := fmt.Sprintf(`
				SELECT nama_produk, kategori, harga, stok, gambar, satuan
				FROM produk
				WHERE nama_produk IN (%s)
			`, placeholders)

			args := make([]interface{}, len(topProducts))
			for i, v := range topProducts {
				args[i] = v
			}

			detailRows, err := db.Query(query, args...)
			if err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}
			defer detailRows.Close()

			for detailRows.Next() {
				var pd ProductDetail
				if err := detailRows.Scan(&pd.NamaProduk, &pd.Kategori, &pd.Harga, &pd.Stok, &pd.Gambar, &pd.Satuan); err == nil {
					products = append(products, pd)
				}
			}
		}

		data := map[string]interface{}{
			"SalesData":     sales,
			"ProductList":   products,
			"SelectedMonth": month,
			"MonthOptions":  months,
		}

		tmpl.ExecuteTemplate(w, "ownerproduct", data)
	}
}
