    <script type="text/javascript" src="https://unpkg.com/wangeditor/dist/wangEditor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/21.5.2/i18next.min.js"
        integrity="sha512-3mwNR8Z6/dK2VqGoxFfIT0wjEODvTj1l2OkWf6s3hTw2Ei7chZ1YYPpCP+uq2kc+jjEf5C7hhyI9yP75vWYsbg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        const createEdit = (textarea_css_feature, height) => {
            let div_css_feature = "div_description"
            const $text1 = document.querySelector(textarea_css_feature)
            const _div = document.createElement("DIV");
            _div.id = div_css_feature;
            div_css_feature = '#' + div_css_feature;
            $text1.parentNode.insertBefore(_div, $text1)
            const E = window.wangEditor
            const editor = new E(div_css_feature)
            if (height) {
                editor.config.height = height
            }
editor.config.zIndex =0;
            // 選擇語言
            editor.config.lang = 'zh-TW'
            // 自定義語言
            editor.config.languages['zh-TW'] = {
                wangEditor: {
                    重置: '重置',
                    插入: '插入',
                    默认: '初始化',
                    创建: '建立',
                    修改: '修改',
                    如: '如',
                    请输入正文: '請輸入文字',
                    menus: {
                        title: {
                            标题: '標題',
                            加粗: '加粗',
                            字号: '字體大小',
                            字体: '字體',
                            斜体: '斜體',
                            下划线: '底線',
                            删除线: '刪除',
                            缩进: '縮排',
                            行高: '行高',
                            文字颜色: '文字顏色',
                            背景色: '背景色',
                            链接: '連結',
                            序列: '序列',
                            对齐: '對齊',
                            引用: '引用',
                            表情: '表情',
                            图片: '圖片',
                            视频: '影片',
                            表格: '表格',
                            代码: 'Code',
                            分割线: '分割線',
                            恢复: '下一步',
                            撤销: '上一步',
                            全屏: '全螢幕',
                            取消全屏: '取消全螢幕',
                            待办事项: '代辦事項',
                        },
                        dropListMenu: {
                            设置标题: '設定標題',
                            背景颜色: '背景顔色',
                            文字颜色: '文字顔色',
                            设置字号: '設定字體大小',
                            设置字体: '設定字體',
                            设置缩进: '設定縮排',
                            对齐方式: '對齊方式',
                            设置行高: '設定行高',
                            序列: '序列',
                            head: {
                                正文: '正文',
                            },
                            indent: {
                                增加缩进: '增加縮排',
                                减少缩进: '減少縮排',
                            },
                            justify: {
                                靠左: '靠左',
                                居中: '居中',
                                靠右: '靠右',
                                两端: '兩端',
                            },
                            list: {
                                无序列表: '無序列錶',
                                有序列表: '有序列錶',
                            },
                        },
                        panelMenus: {
                            emoticon: {
                                默认: '預設',
                                新浪: 'sina',
                                emoji: 'emoji',
                                手势: '小手手',
                            },
                            image: {
                                上传图片: '上傳圖片',
                                网络图片: '線上圖片',
                                图片地址: '圖片網址',
                                图片文字说明: '圖片文字說明',
                                跳转链接: '跳轉鏈接',
                            },
                            link: {
                                链接: '連結',
                                链接文字: '連結文字',
                                取消链接: '取消連結',
                                查看链接: '查看連結',
                            },
                            video: {
                                插入视频: '插入影片',
                                上传视频: '上傳影片',
                            },
                            table: {
                                行: '行',
                                列: '列',
                                的: '的',
                                表格: '表格',
                                添加行: '新增行',
                                删除行: '刪除行',
                                添加列: '新增列',
                                删除列: '刪除列',
                                设置表头: '設定表頭',
                                取消表头: '取消表頭',
                                插入表格: '插入表格',
                                删除表格: '刪除表格',
                            },
                            code: {
                                删除代码: '刪除Code',
                                修改代码: '修改Code',
                                插入代码: '插入Code',
                            },
                        },
                    },
                    validate: {
                        张图片: '張圖片',
                        大于: '大於',
                        图片链接: '圖片連結',
                        不是图片: '不是圖片',
                        返回结果: '返回結果',
                        上传图片超时: '上傳圖片超時',
                        上传图片错误: '上傳圖片錯誤',
                        上传图片失败: '上傳圖片失敗',
                        插入图片错误: '插入圖片錯誤',
                        一次最多上传: '一次最多上傳',
                        下载链接失败: '下載鏈接失敗',
                        图片验证未通过: '圖片驗證未通過',
                        服务器返回状态: '伺服器返回狀態',
                        上传图片返回结果错误: '上傳圖片返回結果錯誤',
                        请替换为支持的图片类型: '請更換成支援的圖片類型',
                        您插入的网络图片无法识别: '您上傳的線上圖片無法識別',
                        您刚才插入的图片链接未通过编辑器校验: '您剛才插入的圖片連結未通過編輯器驗證',
                        插入视频错误: '插入影片錯誤',
                        视频链接: '影片連結',
                        不是视频: '不是影片',
                        视频验证未通过: '影片驗證未通過',
                        个视频: '個影片',
                        上传视频超时: '上傳影片超時',
                        上传视频错误: '上傳影片錯誤',
                        上传视频失败: '上傳影片失敗',
                        上传视频返回结果错误: '上傳影片返回結果錯誤',
                    },
                },
            }
            // 引入 i18next 插件
            editor.i18next = i18next
            editor.config.onchange = (html) => {
                // 第二步同步更新到 textarea
                $text1.value = html
                console.log('editor text: ', html === '')
                if (html == '') {
                    editor.txt.html("<div style='display: none;'><div/>");
                }
            }

            editor.config.uploadImgServer = "{{ route('upload-img') }}"
            editor.config.uploadFileName = 'image';


            // 配置全螢幕功能按鈕是否顯示
            editor.config.showFullScreen = false;

            editor.create()
            // 第一步，初始化 textarea 的值
            editor.txt.html($text1.value);

            console.log(div_css_feature)

            {{-- setTimeout(() => {
                document.querySelectorAll(`${div_css_feature}>div`).forEach(item => {
                    item.style.zIndex = 0
                })
            }, 100) --}}


        }
    </script>
