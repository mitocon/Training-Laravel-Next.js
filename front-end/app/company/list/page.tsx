"use client"; // クライアントコンポーネントとして明示

import { useEffect, useState } from "react";

type CompanyData = {
  company_name: string;
  stock_code: string;
  announcement_date: string;
  revenue: string;
  profit: string;
};

const Companies = () => {
  const [data, setData] = useState<CompanyData[]>([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch("/data.json");
        const jsonData: CompanyData[] = await response.json();
        setData(jsonData);
      } catch (error) {
        console.error("データ取得に失敗しました", error);
      }
    };

    fetchData();
  }, []);

  const styles: { th: React.CSSProperties; td: React.CSSProperties } = {
    th: {
      border: "1px solid #ddd",
      padding: "8px",
      textAlign: "left",
      backgroundColor: "#f2f2f2",
    },
    td: {
      border: "1px solid #ddd",
      padding: "8px",
    },
  };

  return (
    <div style={{ padding: "20px" }}>
      <h1>上場企業の決算発表データ</h1>
      <table style={{ width: "100%", borderCollapse: "collapse" }}>
        <thead>
          <tr>
            <th style={styles.th}>会社名</th>
            <th style={styles.th}>証券コード</th>
            <th style={styles.th}>発表日</th>
            <th style={styles.th}>売上高</th>
            <th style={styles.th}>利益</th>
          </tr>
        </thead>
        <tbody>
          {data.map((company, index) => (
            <tr key={index}>
              <td style={styles.td}>{company.company_name}</td>
              <td style={styles.td}>{company.stock_code}</td>
              <td style={styles.td}>{company.announcement_date}</td>
              <td style={styles.td}>{company.revenue}</td>
              <td style={styles.td}>{company.profit}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Companies;
