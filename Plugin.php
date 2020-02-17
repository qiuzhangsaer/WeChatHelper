<?php

/**
 * Typecho 微信助手
 * 对冰剑版本进行精简后的个人公众号版本。
 *
 * @package WeChatHelper
 * @author 心灵导师安德烈
 * @version 2.2.3
 * @link https://www.xvkes.cn
 */
class WeChatHelper_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addAction('wechatHelper', 'WeChatHelper_Action');
        Helper::addRoute('wechat', '/wechat', 'WeChatHelper_Action', 'link');

        Helper::addAction('WeChat', 'WeChatHelper_Action');

        return ('微信助手已经成功激活，请进入设置Token!');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        $options = Typecho_Widget::widget('Widget_Options');

        Helper::removeRoute('wechat');
        Helper::removeAction('wechatHelper');
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {

        /** 用户添加订阅欢迎语 **/
        $welcome = new Typecho_Widget_Helper_Form_Element_Textarea('welcome', NULL, '欢迎关注！' . chr(10) . '发送\'h\'让我来给你介绍一下！', '订阅欢迎语', '用户订阅之后主动发送的一条欢迎语消息。');
        $form->addInput($welcome);
        /** 返回最大结果条数 **/
        $imageDefault = new Typecho_Widget_Helper_Form_Element_Text('imageDefault', NULL, 'https://www.xvkes.cn/logoavatar/avatar.jpg', _t('默认显示图片'), '图片链接，支持JPG、PNG格式，推荐图为80*80。');
        $form->addInput($imageDefault);
        /** 返回最大结果条数 **/
        $imageNum = new Typecho_Widget_Helper_Form_Element_Text('imageNum', NULL, '5', _t('返回图文数量'), '图文消息数量，限制为10条以内。');
        $imageNum->input->setAttribute('class', 'mini');
        $form->addInput($imageNum);
        /** 文章截取字数 **/
        $subMaxNum = new Typecho_Widget_Helper_Form_Element_Text('subMaxNum', NULL, '200', _t('文章截取字数'), '显示单条文章时，截取文章内容字数。');
        $subMaxNum->input->setAttribute('class', 'mini');
        $form->addInput($subMaxNum);

        /** Token **/
        $token = new Typecho_Widget_Helper_Form_Element_Text('token', NULL, '', _t('令牌(Token)'), '需要与开发模式服务器配置中填写一致。服务器地址(URL)：' . Helper::options()->index . '/wechat');
        $form->addInput($token);

    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }
}
